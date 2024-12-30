@extends('layouts.admin.master', ['title' => 'Transaction Details - Bookstore'])

@section('content')
<div class="py-5">
    <div class="row justify-content-center">
        <!-- Transaction Details Section -->
        <div class="col-lg-8 col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center font-weight-bold">Transaction Details</h3>

                    <!-- Transaction Summary -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Invoice ID:</h5>
                            <p class="mb-0 text-muted">{{ $transaction->invoice }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Shipping Address:</h5>
                            <p class="mb-0 text-muted">{{ $transaction->address }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Status:</h5>
                            <span class="badge
                                @if($transaction->status == 'PAID') bg-success
                                @elseif($transaction->status == 'UNPAID') bg-warning
                                @elseif($transaction->status == 'EXPIRED') bg-secondary
                                @else bg-danger
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <!-- Courier Details -->
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Courier Details</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-bold mb-0">Courier Name:</h6>
                            <p class="mb-0 text-muted">{{ $transaction->courier_name }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-bold mb-0">Courier Service:</h6>
                            <p class="mb-0 text-muted">{{ $transaction->courier_service }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-bold mb-0">Shipping Cost:</h6>
                            <p class="mb-0 text-muted">Rp {{ number_format($transaction->courier_cost, 2) }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Transaction Items Table -->
                    <h6 class="mb-3 font-weight-bold">Transaction Items</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->transactionDetails as $detail)
                                <tr>
                                    <td>{{ $detail->book->title }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>Rp {{ number_format($detail->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold">Total Price (Before Shipping):</h5>
                        <p class="text-muted">Rp {{ number_format($transaction->transactionDetails->sum(function ($detail) {
                            return $detail->price * $detail->qty;
                        }), 2) }}</p>
                    </div>

                    <!-- Shipping Cost -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold">Shipping Cost:</h5>
                        <p class="text-muted">Rp {{ number_format($transaction->courier_cost, 2) }}</p>
                    </div>

                    <!-- Grand Total -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold">Grand Total (After Shipping):</h5>
                        <p class="text-primary h4 font-weight-bold">Rp {{ number_format($transaction->grand_total, 2) }}</p>
                    </div>

                    @if($transaction->status == 'UNPAID')
                    <!-- Payment Button -->
                    <div class="text-center mt-4">
                        <button id="pay-button" class="btn btn-primary btn-lg shadow-sm">Pay Now</button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Back to Transactions -->
            <div class="mt-4 text-center">
                <a href="{{ route('customers.transactions.index') }}" class="btn btn-outline-secondary">Back to Transactions</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton?.addEventListener('click', function() {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function() {
                window.location.href = "{{ route('customers.transactions.index') }}";
            },
            onPending: function() {
                window.location.href = "{{ route('customers.transactions.index') }}";
            },
            onError: function() {
                window.location.href = "{{ route('customers.transactions.index') }}";
            }
        });
    });
</script>
@endpush
@endsection