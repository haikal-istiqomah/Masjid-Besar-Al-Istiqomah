<?php
// app/Http/Controllers/MidtransController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Donasi;    // sementara pakai model Donasi milikmu
use App\Models\Payment;   // opsional: jika sudah mulai migrasi ke payments

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        Log::info('midtrans.notification payload', $request->all());

        // BACA DARI services.midtrans
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        try {
            $notif = new Notification();

            $orderId     = $notif->order_id;
            $trxStatus   = $notif->transaction_status; // settlement|capture|pending|expire|cancel|deny|refund|chargeback
            $fraudStatus = $notif->fraud_status;       // accept|challenge|deny

            // ====== Opsi A: SEMENTARA update ke tabel Donasi lamamu ======
            if ($donasi = Donasi::where('order_id', $orderId)->first()) {
                $new = match ($trxStatus) {
                    'capture', 'settlement' => ($fraudStatus === 'accept') ? 'Success' : $donasi->status,
                    'pending'               => 'Pending',
                    'deny', 'expire', 'cancel' => 'Failed',
                    'refund'                => 'Refunded',
                    default                 => $donasi->status,
                };

                // Idempoten: hanya update jika berubah
                if ($donasi->status !== $new) {
                    $donasi->update(['status' => $new]);
                }
            }

            // ====== Opsi B: Jika sudah pakai tabel payments ======
            if ($payment = Payment::where('order_id', $orderId)->first()) {
                $map = [
                    'capture'    => 'paid',
                    'settlement' => 'paid',
                    'pending'    => 'pending',
                    'deny'       => 'failed',
                    'expire'     => 'expired',
                    'cancel'     => 'canceled',
                    'refund'     => 'refunded',
                    'chargeback' => 'chargeback',
                ];
                $new = $map[$trxStatus] ?? $payment->status;

                if ($payment->status !== $new) {
                    $payment->update([
                        'status' => $new,
                        'paid_at' => in_array($new, ['paid','refunded']) ? now() : $payment->paid_at,
                        'raw_notification' => $request->all(),
                    ]);
                }
            }

            return response()->json(['ok' => true], 200);
        } catch (\Throwable $e) {
            Log::error('midtrans.notification error: '.$e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
