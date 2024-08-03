@extends('layouts.app')

@section('title', '419')

@section('content')
    <section class="h-screen d-flex justify-content-center align-items-center">
        <div class="section__title flex-column text-center">
            <h2 class="fw-bold">419</h2>
            <p class="h5 mt-3 text-normal">Session has expired</p>
            <p class="h6 mt-3 text-normal w-md-70">Sorry, your session has expired. Please refresh and try again, Thank you.
            </p>
            <a href="{{ url('/') }}" class="btn btn-sm btn-primary rounded-pill mt-4">
                Home <i class="mdi mdi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>
@endsection
