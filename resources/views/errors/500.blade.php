@extends('layouts.app')

@section('title', '500')

@section('content')
    <section class="h-screen d-flex justify-content-center align-items-center">
        <div class="section__title flex-column text-center">
            <h2 class="fw-bold">500</h2>
            <p class="h5 mt-3 text-normal">Internal Server Error</p>
            <p class="h6 mt-3 text-normal w-md-70">The server has been deserted for a while. Try to refresh this page or back
                to previous page, Thank you.</p>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary rounded-pill mt-4">
                Back <i class="mdi mdi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>
@endsection
