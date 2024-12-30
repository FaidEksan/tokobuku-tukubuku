@extends('layouts.admin.master', ['title' => 'Transactions - Bookstore'])

@section('content')
<div class="container py-3">
    <h3 class="mb-4">Your Transactions</h3>

    @if($transactions->isEmpty())
    <div class="alert alert-warning text-center">
        You have no transactions.
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Invoice</th>
                    <th>Status</th>
                    <th>Grand Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->invoice }}</td>
                    <td>
                        <span class="badge
                                    @if($transaction->status == 'PAID') bg-success
                                    @elseif($transaction->status == 'UNPAID') bg-warning
                                    @elseif($transaction->status == 'EXPIRED') bg-secondary
                                    @else bg-danger
                                    @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($transaction->grand_total) }}</td>

                    <td>
                        <a href="{{ route('customers.transactions.show', $transaction->id) }}"
                            class="btn btn-primary btn-sm">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $transactions->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection