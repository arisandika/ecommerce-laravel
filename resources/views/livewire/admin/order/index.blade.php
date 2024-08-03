@section('title', 'Orders')

<section>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Transaction List</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-xxl-4 col-lg-4">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input id="search" name="search" type="text" class="form-control"
                                        autocomplete="off" id="searchTableList" placeholder="Search order..."
                                        wire:model="search" wire:keydown="updateFilter">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-xxl-3 col-lg-3">
                            <select id="sortBy" name="sortBy" class="form-select rounded-pill" wire:model="sortBy"
                                wire:change="updateFilter" style="padding-left: 14px">
                                <option value="latest" selected="selected">Latest</option>
                                <option value="oldest">Oldest</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Pending</option>
                                <option value="packaged">Being Packaged</option>
                                <option value="toship">To Ship</option>
                                <option value="receive">To Receive</option>
                                <option value="completed">To Completed</option>
                            </select>
                        </div>
                        <div class="col-6 col-xxl-3 col-lg-3">
                            <select id="perPage" name="perPage" class="form-select rounded-pill" wire:model="perPage"
                                wire:change="updateFilter" style="padding-left: 14px">
                                <option value="10" selected="selected">Show 10</option>
                                <option value="20">Show 20</option>
                                <option value="40">Show 40</option>
                            </select>
                        </div>
                        <div class="col-2 col-xxl-2 col-lg-2">
                            <button type="button" class="btn btn-success btn-rounded w-100" onclick="filterData();"><i
                                    class="mdi mdi-filter-outline align-middle"></i> <span class="d-md-inline d-none">
                                    Filter</span></button>
                        </div>
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
                                @forelse ($orders as $order)
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
                        <!-- Pagination links -->
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.admin.order.edit-status')
</section>
