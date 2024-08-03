@extends('layouts.app')

@section('title', 'Payment')

@section('content')
    <section>
        <div class="space-4"></div>
        <div class="order-complete">
            <div class="row">
                <div class="col-md-5">
                    <div class="checkout__totals-wrapper">
                        <div class="checkout__totals rounded-lg">
                            <h3 class="text-center fw-bold">Billing Details</h3>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td>@currency($order->subtotal_price)</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td>@currency($order->shipping_cost)</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td>@currency($order->total_price)</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="space-3"></div>
                            <button type="button" id="pay-button" class="btn btn-primary btn-checkout rounded-pill">
                                <span>Pay Now</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="order-info">
                        <div class="order-info__item mb-3">
                            <h6>Order ID</h6>
                            <span>{{ $order->id }}</span>
                        </div>
                        <div class="order-info__item mb-3">
                            <h6>Status</h6>
                            <span>{{ $order->status_order }}</span>
                        </div>
                        <div class="order-info__item mb-3">
                            <h6>Date</h6>
                            <span>{{ $order->created_at }}</span>
                        </div>
                        <div class="order-info__item mb-3">
                            <h6>Total</h6>
                            <span>@currency($order->total_price)</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Payment Method</h6>
                            <span>{{ $order->payment_method }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $order->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    window.location.href = '{{ route('checkout.success', $order->id) }}'
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endpush
