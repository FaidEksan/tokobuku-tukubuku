<?php


namespace App\Http\Controllers\Web;

use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebNotificationHandlerController extends Controller
{
    public function paymentNotification(Request $request)
    {
        // Ambil payload dari request
        $payload = $request->getContent();
        $notification = json_decode($payload);

        // Verifikasi signature untuk memastikan keamanan
        $signatureKey = hash('sha512', $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));
        if ($notification->signature_key != $signatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        // Ambil data status transaksi dan tipe pembayaran
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;

        // Cari transaksi berdasarkan invoice
        $transaction = Transaction::where('invoice', $notification->order_id)->first();


        // Jika transaksi tidak ditemukan
        if (!$transaction) {
            return response(['message' => 'Transaction not found'], 404);
        }

        // Tentukan status transaksi berdasarkan status dari Midtrans
        switch ($transactionStatus) {
            case 'capture':
                if ($paymentType === 'credit_card') {
                    // Jika jenis pembayaran credit card, tidak ada aksi tambahan (misalnya challenge oleh FDS)
                    break;
                }
                // Untuk transaksi capture, anggap berhasil dan update status ke PAID
                $transaction->update([
                    'status' => TransactionStatus::PAID
                ]);
                break;

            case 'settlement':
                // Update status transaksi ke PAID
                $transaction->update([
                    'status' => TransactionStatus::PAID
                ]);
                break;

            case 'pending':
                // Update status transaksi ke PENDING
                $transaction->update([
                    'status' => TransactionStatus::UNPAID
                ]);
                break;

            case 'deny':
                // Update status transaksi ke CANCELLED atau FAILED
                $transaction->update([
                    'status' => TransactionStatus::CANCELLED
                ]);
                break;

            case 'expire':
                // Update status transaksi ke EXPIRED
                $transaction->update([
                    'status' => TransactionStatus::EXPIRED
                ]);
                break;

            case 'cancel':
                // Update status transaksi ke CANCELLED
                $transaction->update([
                    'status' => TransactionStatus::CANCELLED
                ]);
                break;

            default:
                return response(['message' => 'Unhandled transaction status'], 400);
        }

        // mengembalikan respons sukses
        return response(['message' => 'Transaction status updated successfully'], 200);
    }
}
