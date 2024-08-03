@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
    <section>
        <div class="section__title flex-column text-center">
            <h2 class="fw-bold">Thank you</h2>
            <p class="h5 mt-3 text-normal">Your order was completed successfully</p>
            <p class="h6 mt-3 text-normal w-md-70">An email receipt including the details about your order has been sent to
                the email address provided. Please keep it for your records.</p>
            <a href="/shop" class="btn btn-sm btn-primary rounded-pill mt-4"><span>Shop
                    now</span></a>
        </div>
        <div class="order-complete">
            <div class="row">
                <div class="col-md-5">
                    <div class="checkout__totals-wrapper">
                        <div class="checkout__totals rounded-lg">
                            <h3 class="text-center fw-bold">Order Details</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $item)
                                        <tr>
                                            <td>
                                                {{ $item->product->name }} x {{ $item->quantity }}
                                            </td>
                                            <td>
                                                @currency($item->price * $item->quantity)
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
