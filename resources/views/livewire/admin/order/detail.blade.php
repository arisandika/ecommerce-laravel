@extends('livewire.layouts.admin')

@section('title', 'Order Details')

@section('back-link')
    <div class="col-4 col-md-6 text-end">
        <a href="{{ url('/admin/orders') }}" wire:navigate class="text-primary font-16">Back <i
                class="mdi mdi-chevron-right"></i></a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="order-detail">
                        <div class="order-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="order-info__item">
                                        <h6>Order ID</h6>
                                        <p>{{ $order->id }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Tracking No</h6>
                                        <p>{{ $order->tracking_no }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Status</h6>
                                        <p>{{ $order->status_order }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Date</h6>
                                        <p>{{ $order->created_at }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Total</h6>
                                        <p>@currency($order->total_price)</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Payment Method</h6>
                                        <p>{{ $order->payment_method }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-info__item">
                                        <h6>Full Name</h6>
                                        <p>{{ $order->fullname }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Email</h6>
                                        <p>{{ $order->email }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Phone</h6>
                                        <p>{{ $order->phone }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Address</h6>
                                        <p>{{ $order->address }}</p>
                                    </div>
                                    <div class="order-info__item">
                                        <h6>Zip Code</h6>
                                        <p>{{ $order->postcode }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                            id="order-list">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Price</th>
                                    <th class="align-middle">Quantity</th>
                                    <th class="align-middle">Total</th>
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
            </div>
        </div>
    </div>
@endsection
