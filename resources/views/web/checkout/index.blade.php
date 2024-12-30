@extends('layouts.web.master', ['title' => 'Checkout - Bookstore'])
@section('content')

<div class="py-5">
    <div class="row justify-content-center">
        <!-- Checkout Information Section -->
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center font-weight-bold">Confirm Your Order</h3>

                    <!-- Order Summary -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Invoice ID:</h5>
                            <p class="mb-0 text-muted">{{ $transaction->invoice }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Delivery Address:</h5>
                            <p class="mb-0 text-muted">{{ $transaction->address }}</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="font-weight-bold mb-0">Total Amount:</h5>
                            <p class="text-success h4 font-weight-bold mb-0">Rp {{
                                number_format($transaction->grand_total) }}</p>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="text-center">
                        <button id="pay-button" class="btn btn-primary btn-lg btn-block shadow-sm">Pay Now</button>
                    </div>

                </div>
            </div>

            <!-- Back to Cart -->
            <div class="mt-4 text-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Back to Cart</a>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
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
    })
</script>

@endpush
@endsection