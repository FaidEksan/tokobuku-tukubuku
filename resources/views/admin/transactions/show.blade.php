<!-- resources/views/admin/transactions/show.blade.php -->

@extends('layouts.admin.master', ['title' => 'Transaction Details - Bookstore'])

@section('content')
<div class="container py-3">
    <h4 class="card-title">Transaction Details</h4>
    <p class="text-muted mb-4">Details of transaction with Invoice #{{ $transaction->invoice }}</p>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Invoice: {{ $transaction->invoice }}</h5>
            <p><strong>User:</strong> {{ $transaction->user->name }}</p>
            <p><strong>Total Amount:</strong> Rp {{ number_format($transaction->grand_total) }}</p>
            <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h5>Items</h5>
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->transactionDetails as $detail)
                    <tr>
                        <td>{{ $detail->book->title }}</td> 
                        <td>{{ $detail->qty }}</td>
                        <td>Rp {{ number_format($detail->price) }}</td>
                        <td>Rp {{ number_format($detail->price * $detail->qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary mt-3">Back to Transactions</a>
</div>
@endsection