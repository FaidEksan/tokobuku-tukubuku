<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function index(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $validatedData = $request->validate([
            'address' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'courier_name' => 'required|string',
            'courier_service' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'weight' => 'required|integer',
        ]);

        $courierDetails = [
            'name' => $validatedData['courier_name'],
            'service' => $validatedData['courier_service'],
        ];

        $transaction = $this->checkoutService->createTransaction(
            $validatedData['address'],
            $validatedData['province_id'],
            $validatedData['city_id'],
            $courierDetails,
            $validatedData['shipping_cost'],
            $validatedData['weight']
        );

        if (!$transaction) {
            return back()->with('error', 'Transaction failed.');
        }

        try {
            $snapToken = $this->checkoutService->getMidtransSnapToken($transaction, $cartItems);
            return view('web.checkout.index', compact('snapToken', 'transaction'));
        } catch (\Exception $e) {
            return back()->with('error', 'Midtrans error: ' . $e->getMessage());
        }
    }
}