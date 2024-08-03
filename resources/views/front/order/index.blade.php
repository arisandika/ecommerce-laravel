@extends('layouts.account')

@section('title', 'My Order')

@section('content')
    <div class="page-content my-account__orders-list">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th colspan="2">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @if ($order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->status_order }}</td>
                            <td>@currency($order->total_price)</td>
                            <td>
                                <a href="{{ url('/account/orders/' . $order->id) }}"
                                    class="btn btn-primary rounded-pill waves-effect waves-light btn-sm">View <i
                                        class="mdi mdi-arrow-right ms-1"></i></a>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5">
                            No Orders Available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
