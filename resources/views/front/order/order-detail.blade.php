@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <section>
        <div class="my-4">
            <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill waves-effect waves-light btn-sm">Back
                <i class="mdi mdi-arrow-right ms-1"></i></a>
        </div>
        <div class="order-detail">
            <div class="order-info">
                <div class="row">
                    <div class="col-md-6">
                        <div class="order-info__item">
                            <h6>Order ID</h6>
                            <span>{{ $order->id }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Tracking No</h6>
                            <span>{{ $order->tracking_no }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Status</h6>
                            <span>{{ $order->status_order }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Date</h6>
                            <span>{{ $order->created_at }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Total</h6>
                            <span>@currency($order->total_price)</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Payment Method</h6>
                            <span>{{ $order->payment_method }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="order-info__item">
                            <h6>Billing Name</h6>
                            <span>{{ $order->fullname }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Email</h6>
                            <span>{{ $order->email }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Phone</h6>
                            <span>{{ $order->phone }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Address</h6>
                            <span>{{ $order->address }}</span>
                        </div>
                        <div class="order-info__item">
                            <h6>Zip Code</h6>
                            <span>{{ $order->postcode }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-account">
            <div class="page-content my-account__orders-list">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $item)
                            <tr>
                                <td>{{ $item->product->name }}
                                    @if ($item->productSize)
                                        <div class="mt-1">
                                            <span class="shopping-cart__size">Size :
                                                {{ $item->productSize->size->name }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @currency($item->price)
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @currency($item->price * $item->quantity)
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
