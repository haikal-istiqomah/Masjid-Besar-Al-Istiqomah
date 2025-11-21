<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Donasi;
use App\Models\Payment;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        Log::info('midtrans.notification payload: ' . json_encode($request->all()));

        // Ambil field penting dari payload
        $orderId      = (string) $request->input('order_id');
        $statusCode   = (string) $request->input('status_code');        // '201', '200', dst.
        $grossAmount  = (string) $request->input('gross_amount');       // "15000.00"
        $trxStatus    = (string) $request->input('transaction_status'); // pending|settlement|...
        $fraudStatus  = (string) $request->input('fraud_status');       // accept|challenge|deny
        $ptype        = (string) $request->input('payment_type');       // echannel, bank_transfer, cc, etc.
        $sigFromMid   = (string) $request->input('signature_key');

        // Validasi signature
        $serverKey = (string) config('services.midtrans.server_key');
        $expected  = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        if (!hash_equals($expected, $sigFromMid)) {
            Log::warning('midtrans.notification invalid signature for order '.$orderId);
            return response('Invalid signature', 403);
        }

        // Map status Midtrans -> status internal (lowercase)
        $mappedPayment = match ($trxStatus) {
            'capture'    => ($ptype === 'credit_card' && $fraudStatus === 'challenge') ? 'challenge' : 'paid',
            'settlement' => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'expire'     => 'expired',
            'cancel'     => 'canceled',
            'refund'     => 'refunded',
            'chargeback' => 'chargeback',
            default      => 'pending'
        };

        // Untuk tabel Donasi legacy: gunakan lowercase yang umum
        $mappedDonasi = match ($trxStatus) {
            'capture', 'settlement' => ($fraudStatus === 'accept') ? 'success' : 'pending', // aman: 'success' atau 'pending'
            'pending'               => 'pending',
            'deny'                  => 'failed',
            'expire'                => 'expired',
            'cancel'                => 'failed',   // kalau constraintmu hanya izinkan 'failed'
            'refund'                => 'refunded',
            default                 => 'pending',
        };

        try {
            // ===== Donasi (jika ada barisnya) =====
            if ($donasi = Donasi::where('order_id', $orderId)->first()) {
                $needSave = false;
            
                // status (lowercase, sesuai constraint)
                if ($donasi->status !== $mappedDonasi) {
                    $donasi->status = $mappedDonasi;
                    $needSave = true;
                }
            
                // simpan payment_type bila ada/berubah
                if ($ptype && $donasi->payment_type !== $ptype) {
                    $donasi->payment_type = $ptype;
                    $needSave = true;
                }
            
                if ($needSave) {
                    $donasi->save();  // assignment + save => aman
                }
            }

            // ===== Payments (jika ada barisnya) =====
            if ($payment = Payment::where('order_id', $orderId)->first()) {
                    // 1) Validasi amount (Midtrans kirim string "15000.00")
                    $midtransAmount = (int) round((float) $grossAmount);   // 15000.00 -> 15000
                    $localAmount    = (int) round((float) $payment->amount);
                
                    if ($localAmount !== $midtransAmount) {
                        Log::warning("midtrans.notification amount mismatch for $orderId | local={$localAmount} midtrans={$midtransAmount}");
                        return response('Amount mismatch', 400);
                    }
                
                    // 2) Update status/channel/raw
                    if ($payment->status !== $mappedPayment) {
                        $payment->status = $mappedPayment;
                        $payment->channel = $ptype;
                        if (in_array($mappedPayment, ['paid','refunded']) && !$payment->paid_at) {
                            $payment->paid_at = now();
                        }
                        $payment->raw_notification = $request->all();
                        $payment->save();
                    }
                }
                // zakat // ===== ZAKAT (jika ada barisnya) =====
            if (str_starts_with($orderId, 'ZAKAT-')) {
                $zakat = \App\Models\Zakat::where('order_id', $orderId)->first();
                if ($zakat) {
                    $zakatStatus = match ($trxStatus) {
                        'capture', 'settlement' => 'paid',
                        'pending'               => 'pending',
                        'deny'                  => 'failed',
                        'expire'                => 'expired',
                        'cancel'                => 'failed',
                        default                 => 'pending',
                    };

                    $zakat->update([
                        'status' => $zakatStatus,
                        'midtrans_response' => $request->all()
                    ]);

                    Log::info("Zakat {$orderId} updated to status {$zakatStatus}");
                }
            }

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            Log::error('midtrans.notification exception: '.$e->getMessage().' @'.$e->getFile().':'.$e->getLine());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function finish(Request $request)
    {
        return view('front.donasi.sukses', ['result' => $request->all()]);
    }

    // Helper untuk membuat snap token (dipanggil dari ZakatController)
    public function createSnapTokenForOrder($orderId, $amount, $customerName = null, $customerEmail = null)
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$clientKey = config('services.midtrans.client_key');

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail,
            ],
        ];

        $snap = \Midtrans\Snap::createTransaction($params);
        return $snap->token; // token untuk snap
    }

}
