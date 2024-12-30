<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\CheckoutService; // Pastikan ini diimport
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }


    public function show($id)
    {
        $transaction = Transaction::with('transactionDetails.book')->findOrFail($id);

        $snapToken = null;
        if ($transaction->status == 'UNPAID') {
            $checkoutService = new CheckoutService();
            $snapToken = $checkoutService->getMidtransSnapToken($transaction, $transaction->transactionDetails);
        }

        return view('customer.transactions.show', compact('transaction', 'snapToken'));
    }
}