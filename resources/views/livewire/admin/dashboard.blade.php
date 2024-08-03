@section('title', 'Dashboard')

<section>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Orders</p>
                                    <h4 class="mb-0">{{ $orders->count() }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Products</p>
                                    <h4 class="mb-0">{{ $products->count() }}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-archive-in font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Total Sells</p>
                                    <h4 class="mb-0">@currency($orderSuccess->sum('total_price'))</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Latest Transaction</h4>
                        <a href="{{ url('/admin/orders') }}" wire:navigate>See All <i
                                class="mdi mdi-chevron-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                            id="order-list">
                            <thead class="table-light">
                                <tr>
                                    <th class="align-middle">Order ID</th>
                                    <th class="align-middle">Billing Name</th>
                                    <th class="align-middle">Date</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Payment Method</th>
                                    <th class="align-middle">View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders->take(5) as $order)
                                    <tr>
                                        <td><a href="javascript: void(0);"
                                                class="text-body fw-bold">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->fullname }}</td>
                                        <td>
                                            {{ $order->created_at }}
                                        </td>
                                        <td>
                                            @currency($order->total_price)
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-pill font-size-11 cursor-pointer @if ($order->status_order == 'Pending' || $order->status_order == 'Cancelled') badge-soft-danger @else badge-soft-success @endif"
                                                data-bs-toggle="modal" data-bs-target="#editStatus"
                                                x-on:click="$wire.getDataEdit('{{ $order->id }}')">
                                                {{ $order->status_order }} <i class="far fa-edit font-size-12 ms-1"></i>
                                            </span>
                                        </td>
                                        <td>
                                            {{ $order->payment_method }}
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/orders/' . $order->id) }}" wire:navigate
                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="pt-4" colspan="7">
                                            <div class="d-flex justify-content-center w-100">
                                                <p>No order available</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.admin.order.edit-status')
</section>
