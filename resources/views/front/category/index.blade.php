@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <h2 class="section__title">All Categories</h2>
    <section class="collections-grid collections-grid_masonry gutters-20">
        <div class="h-md-100">
            <div class="row h-md-100 g-4">
                @foreach ($categories as $category)
                    <div class="col-lg-4">
                        <div class="collection-grid__item h-md-100 position-relative">
                            <div class="background-img rounded-lg"
                                style="background-image: url('{{ Storage::url($category->image) }}');"></div>
                            <div class="content_abs content_top content_left content_top-md content_left-md pt-2">
                                <h5 class="text-capitalize fw-bold mb-1">{{ $category->name }}</h5>
                                <a href="/shop/{{ $category->slug }}" class="link__text text__more">See
                                    products <i class="mdi mdi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
