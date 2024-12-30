<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutService
{
      public function __construct()
      {

            \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
      }

      public function createTransaction($address, $provinceId, $cityId, $courierDetails, $shippingCost, $weight)
      {
            $cartItems = Cart::where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                  return null; // Jika cart kosong
            }

            $cartTotal = $cartItems->sum(fn($item) => $item->price * $item->qty);
            $grandTotal = $cartTotal + $shippingCost; // Tambahkan biaya pengiriman

            // Simpan transaksi utama
            $transaction = Transaction::create([
                  'user_id' => Auth::id(),
                  'province_id' => $provinceId,
                  'city_id' => $cityId,
                  'invoice' => 'INV-' . time(),
                  'address' => $address,
                  'courier_name' => $courierDetails['name'],
                  'courier_service' => $courierDetails['service'],
                  'courier_cost' => $shippingCost,
                  'weight' => $weight,
                  'grand_total' => $grandTotal,
                  'status' => 'UNPAID',
            ]);

            // Simpan detail transaksi
            foreach ($cartItems as $item) {
                  TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'book_id' => $item->book_id,
                        'qty' => $item->qty,
                        'price' => $item->price,
                  ]);
            }

            // Kosongkan cart
            Cart::where('user_id', Auth::id())->delete();

            return $transaction;
      }

      public function getMidtransSnapToken($transaction, $cartItems)
      {
            if ($transaction->reference) {
                  return $transaction->reference;
            }

            $midtrans_params = [
                  'transaction_details' => [
                        'order_id' => $transaction->invoice,
                        'gross_amount' => $transaction->grand_total,
                  ],
                  'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone,
                        'shipping_address' => [
                              'address' => $transaction->address,
                        ],
                  ],
                  'item_details' => $cartItems->map(function ($item) {
                        return [
                              'id' => $item->book_id,
                              'price' => (float) $item->price,
                              'quantity' => (int) $item->qty,
                              'name' => $item->book->title ?: 'Unknown Item',
                        ];
                  })->filter(function ($item) {
                        return $item['price'] > 0 && $item['quantity'] > 0;
                  })->toArray(),
            ];

            $midtrans_params['item_details'][] = [
                  'id' => 'SHIPPING_COST',
                  'price' => (float) $transaction->courier_cost,
                  'quantity' => 1,
                  'name' => 'Shipping Cost',
            ];

            // Mengambil Snap Token dan Redirect URL dari Midtrans
            $snapResponse = Snap::createTransaction($midtrans_params);
            $snapToken = $snapResponse->token;

            // Simpan Snap Token ke transaksi
            $transaction->update(['reference' => $snapToken]);

            return $snapToken;
      }


      public function completeTransaction($transactionId)
      {
            $transaction = Transaction::find($transactionId);

            if ($transaction) {
                  $transaction->status = 'PAID';
                  $transaction->save();

                  return $transaction;
            }

            return null;
      }
}