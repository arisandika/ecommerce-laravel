@extends('layouts.account')

@section('title', 'Dashboard')

@section('content')
    <section>
        <div class="row-profile">
            <div class="col-md-12">
                <div class="card overflow-hidden rounded-lg">
                    <div class="card-profile bg-secondary">
                        <div class="row">
                            <div class="col-7">
                                <h5 class="text-primary">Hi, {{ Auth::user()->name }}!</h5>
                                <p>Account Dashboard</p>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('assets/images/profile-img.png') }}" alt="bg-ilustrator" width="200px"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-profile card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="{{ asset('assets/images/users/default.jpg') }}" alt="profile"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0 text-truncate">Member</p>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-muted mb-0">Your Orders</p>
                                            <h5 class="font-size-15">{{ $orders->count() }}</h5>
                                        </div>
                                        <div class="col-6">
                                            <p class="text-muted mb-0">Revenue</p>
                                            <h5 class="font-size-15">$1245</h5>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('account.orders') }}"
                                            class="btn btn-primary rounded-pill waves-effect waves-light btn-sm">View
                                            Order <i class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row-profile">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Your Orders</p>
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
                                        <p class="text-muted fw-medium">Revenue</p>
                                        <h4 class="mb-0">$35, 723</h4>
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
                                        <p class="text-muted fw-medium">Average Price</p>
                                        <h4 class="mb-0">$16.2</h4>
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
    </section>
@endsection
