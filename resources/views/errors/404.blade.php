@extends('layouts.app')

@section('title', 'Coming Soon')

@section('content')
    <section class="h-screen d-flex justify-content-center align-items-center">
        <div class="section__title flex-column text-center">
            <h2 class="fw-bold">Coming Soon</h2>
            <p class="h5 mt-3 text-normal">This page is under construction</p>
            <p class="h6 mt-3 text-normal w-md-70">Stay connected as we prepare to reveal our latest developments. Your
                anticipation and support fuel our progress, Thank you.</p>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary rounded-pill mt-4">
                Back <i class="mdi mdi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>
@endsection
