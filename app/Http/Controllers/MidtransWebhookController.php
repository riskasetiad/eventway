<?php
namespace App\Http\Controllers;

use App\Mail\TiketBerhasilDibeli;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $notif = $request->all();

        Log::info('Midtrans Webhook Received:', $notif);

        $orderId   = $notif['order_id']; // Contoh: ORDER-5-65fabc9e7d4f3
        $idParts   = explode('-', $orderId);
        $orderDbId = $idParts[1] ?? null;

        if (! $orderDbId) {
            return response()->json(['message' => 'Invalid order ID'], 400);
        }

        $order = Order::find($orderDbId);
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $notif['transaction_status'];

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            // Pastikan status pembayaran berhasil
            if ($order->status_pembayaran != 'berhasil') {
                $order->update([
                    'status_pembayaran' => 'berhasil',
                    'status_tiket'      => 'belum ditukar', // Tiket belum ditukar ketika pembayaran berhasil
                ]);

                // Kirim email hanya jika pembayaran berhasil
                Mail::to($order->email)->send(new TiketBerhasilDibeli($order));
            }
        } elseif ($transactionStatus == 'pending') {
            // Status pembayaran masih pending
            if ($order->status_pembayaran != 'pending') {
                $order->update(['status_pembayaran' => 'pending']);
            }
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            // Status pembayaran gagal
            if ($order->status_pembayaran != 'gagal') {
                $order->update(['status_pembayaran' => 'gagal']);
            }
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }

}
