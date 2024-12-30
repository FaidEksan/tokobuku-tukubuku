<!-- resources/views/admin/transactions/index.blade.php -->

@extends('layouts.admin.master', ['title' => 'All Transactions - Bookstore'])

@section('content')
<div class="container py-3">
    <h4 class="card-title">All Transactions</h4>
    <p class="text-muted mb-5">This table displays all transactions for administrative review.</p>

    @if($transactions->isEmpty())
        <div class="alert alert-warning text-center">
            No transactions found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>User Name</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                            <td>{{ $transaction->invoice }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>Rp {{ number_format($transaction->grand_total) }}</td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $transactions->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection