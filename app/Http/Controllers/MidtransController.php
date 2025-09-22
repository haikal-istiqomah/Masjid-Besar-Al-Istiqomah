<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donasi;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log; // <-- PENTING: Tambahkan ini untuk logging

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // 1. Catat semua notifikasi yang masuk ke dalam file log
        Log::info('Webhook dari Midtrans diterima.', $request->all());

        // 2. Atur Server Key Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            // 3. Buat instance notifikasi dari input server Midtrans
            $notification = new Notification();

            // 4. Ambil detail penting dari notifikasi
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;

            Log::info("Mencari donasi dengan Order ID: {$orderId}");

            // 5. Cari donasi berdasarkan order_id
            $donasi = Donasi::where('order_id', $orderId)->first();

            // 6. Lakukan update HANYA jika donasi ditemukan
            if ($donasi) {
                Log::info("Donasi ditemukan. Status saat ini: {$donasi->status}");
                
                // Lakukan update HANYA jika statusnya masih 'Pending'
                if ($donasi->status == 'Pending') {
                    if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                        if ($fraudStatus == 'accept') {
                            Log::info("Transaksi settlement/capture dan fraud accept. Mengubah status menjadi 'Success'.");
                            $donasi->update(['status' => 'Success']);
                        }
                    } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                        Log::info("Transaksi gagal/dibatalkan. Mengubah status menjadi 'Failed'.");
                        $donasi->update(['status' => 'Failed']);
                    }
                } else {
                    Log::info("Status donasi bukan 'Pending', pembaruan dilewati.");
                }
            } else {
                Log::warning("Donasi dengan Order ID: {$orderId} tidak ditemukan di database.");
            }

            // 7. Beri respons '200 OK' ke Midtrans
            return response()->json(['message' => 'Notification handled successfully'], 200);

        } catch (\Exception $e) {
            // Catat error jika terjadi
            Log::error('Error saat memproses webhook Midtrans: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}

