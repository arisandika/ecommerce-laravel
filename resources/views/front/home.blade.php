@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="swiper-container js-swiper-slider slideshow slideshow-md rounded-lg"
        data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true,
        "pagination": {
          "el": ".slideshow-pagination",
          "type": "bullets",
          "clickable": true
        }
      }'>
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide">
                    <div class="overflow-hidden position-relative h-50">
                        <div class="slideshow-bg">
                            <img src="{{ Storage::url($slider->image) }}" width="1863" alt="{{ $slider->image }}"
                                class="slideshow-bg__img object-fit-cover object-position-right">
                        </div>
                        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                            <h2 class="text-capitalize h2 fw-bold mb-1 animate animate_fade animate_btt animate_delay-5">
                                {{ $slider->name }}</h2>
                            <p class="animate animate_fade animate_btt animate_delay-6 w-md-50">{{ $slider->description }}
                            </p>
                            <div class="animate animate_fade animate_btt animate_delay-7">
                                <a href="{{ url('/shop/' . $slider->slug) }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill">Shop
                                    now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="slideshow-pagination position-left-center"></div>
    </section>
    <div class="space-2"></div>
    <section class="collections-grid collections-grid_masonry gutters-20">
        <div class="h-md-100">
            <div class="row-category h-md-100">
                <div class="col-lg-5 h-md-100">
                    @foreach ($categories->take(1) as $category)
                        <a href="{{ url('/shop/' . $category->slug) }}">
                            <div class="collection-grid__item h-md-100 position-relative">
                                <div class="background-img rounded-lg"
                                    style="background-image: url('{{ Storage::url($category->image) }}');"></div>
                                <div class="content_abs content_top content_left content_top-md content_left-md pt-2">
                                    <h5 class="text-capitalize fw-bold mb-1">{{ $category->name }}</h5>
                                    <span class="link__text text__more">See more <i class="mdi mdi-arrow-right"></i></span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="col-lg-7 d-flex flex-column">
                    <div class="position-relative flex-grow-1">
                        <div class="row-category h-md-100">
                            @php
                                $gridCategories = \App\Models\Category::where('visibility', '0')
                                    ->offset(1)
                                    ->limit(2)
                                    ->get();
                            @endphp
                            @foreach ($gridCategories as $category)
                                <div class="col-md-6 h-md-100">
                                    <a href="{{ url('/shop/' . $category->slug) }}">
                                        <div class="collection-grid__item h-md-100 position-relative">
                                            <div class="background-img rounded-lg"
                                                style="background-image: url('{{ Storage::url($category->image) }}');">
                                            </div>
                                            <div
                                                class="content_abs content_top content_left content_top-md content_left-md pt-2">
                                                <h5 class="text-capitalize fw-bold mb-1">{{ $category->name }}</h5>
                                                <span class="link__text text__more">See more <i
                                                        class="mdi mdi-arrow-right"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="position-relative flex-grow-1 mt-3 mt-lg-3 pt-lg-1">
                        <div class="row-category h-md-100">
                            @php
                                $gridCategories = \App\Models\Category::where('visibility', '0')
                                    ->offset(3)
                                    ->limit(2)
                                    ->get();
                            @endphp
                            @foreach ($gridCategories as $category)
                                <div class="col-md-6 h-md-100">
                                    <a href="{{ url('/shop/' . $category->slug) }}">
                                        <div class="collection-grid__item h-md-100 position-relative">
                                            <div class="background-img rounded-lg"
                                                style="background-image: url('{{ Storage::url($category->image) }}');">
                                            </div>
                                            <div
                                                class="content_abs content_top content_left content_top-md content_left-md pt-2">
                                                <h5 class="text-capitalize fw-bold mb-1">{{ $category->name }}</h5>
                                                <span class="link__text text__more">See more <i
                                                        class="mdi mdi-arrow-right"></i></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="space-7"></div>
    <section class="section-content">
        <h3 class="fw-bold text-capitalize">Bestsellers</h3>
        <a href="/shop" class="link__text text__more">See all products <i class="mdi mdi-arrow-right"></i></a>
    </section>
    <div class="space-4"></div>
    <section class="row">
        @php
            $trendingProducts = \App\Models\Product::where('trending', '1')->get();
        @endphp
        @foreach ($trendingProducts->take(4) as $tproduct)
            <div class="col-6 col-lg-3">
                <div class="product-card mb-4 mb-md-4 mb-xxl-5">
                    <div class="pc__img-wrapper">
                        <div class="background-img">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="{{ url('/shop/' . $tproduct->category->slug . '/' . $tproduct->slug) }}">
                                        @if ($tproduct->productImages->count() > 0)
                                            <img loading="lazy"
                                                src="{{ Storage::url($tproduct->productImages[0]->image) }}" width="400"
                                                height="400" alt="{{ $tproduct->name }}" class="pc__img">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pc__info position-relative">
                        <p class="pc__category">{{ $tproduct->category->name }}</p>
                        <h6 class="pc__title mb-2"><a
                                href="{{ url('/shop/' . $tproduct->category->slug . '/' . $tproduct->slug) }}">{{ $tproduct->name }}</a>
                        </h6>
                        <div class="product-card__price d-flex">
                            <span class="money price">
                                @if ($tproduct->productSizes->count() > 0)
                                    @currency($tproduct->productSizes->first()->size_price)
                                @else
                                    @if ($tproduct->sale_price > 0)
                                        @currency($tproduct->sale_price)
                                    @else
                                        @currency($tproduct->regular_price)
                                    @endif
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <div class="space-6"></div>
    <section class="row-theme">
        <div class="col-md-6">
            <div class="position-relative w-100 h-sm-100 rounded-lg overflow-hidden minh-240 mb-4 mb-sm-0">
                <div class="background-img" style="background-image: url('{{ asset('front/images/accessories.jpg') }}');">
                </div>
                <div class="content_abs top-0 mx-3 mt-3 mt-xl-4 pt-2 px-2">
                    <p class="mb-1 text-secondary">NEW</p>
                    <h3 class="fs-22 fw-bold mb-3">Top 10 Must-Have Digital Accessories for Tech Enthusiasts</h3>
                    <button class="btn btn-theme-color btn-sm rounded-pill">
                        <span>More Info</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative w-100 h-sm-100 rounded-lg overflow-hidden minh-240 mb-4 mb-sm-0">
                <div class="background-img" style="background-image: url('{{ asset('front/images/dualsense.jpg') }}');">
                </div>
                <div class="content_abs top-0 mx-3 mt-3 mt-xl-4 pt-2 px-2">
                    <p class="mb-1 text-secondary">NEW</p>
                    <h3 class="fs-22 fw-bold mb-3">Bring Gaming Worlds to Life: Unleash Your Imagination</h3>
                    <button class="btn btn-theme-blue btn-sm rounded-pill">
                        <span>More Info</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="space-6"></div>
    <section class="section-content">
        <h3 class="fw-bold text-capitalize">Featured Products</h3>
        <a href="/shop" class="link__text text__more">See all products <i class="mdi mdi-arrow-right"></i></a>
    </section>
    <div class="space-4"></div>
    <section class="row">
        @php
            $featuredProducts = \App\Models\Product::where('featured', '1')->get();
        @endphp
        @foreach ($featuredProducts->take(4) as $fproduct)
            <div class="col-6 col-lg-3">
                <div class="product-card mb-4 mb-md-4 mb-xxl-5">
                    <div class="pc__img-wrapper">
                        <div class="background-img">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="{{ url('/shop/' . $fproduct->category->slug . '/' . $fproduct->slug) }}">
                                        @if ($fproduct->productImages->count() > 0)
                                            <img loading="lazy"
                                                src="{{ Storage::url($fproduct->productImages[0]->image) }}"
                                                width="400" height="400" alt="{{ $fproduct->name }}"
                                                class="pc__img">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pc__info position-relative">
                        <p class="pc__category">{{ $fproduct->category->name }}</p>
                        <h6 class="pc__title mb-2"><a
                                href="{{ url('/shop/' . $fproduct->category->slug . '/' . $fproduct->slug) }}">{{ $fproduct->name }}</a>
                        </h6>
                        <div class="product-card__price d-flex">
                            <span class="money price">
                                @if ($fproduct->productSizes->count() > 0)
                                    @currency($fproduct->productSizes->first()->size_price)
                                @else
                                    @if ($fproduct->sale_price > 0)
                                        @currency($fproduct->sale_price)
                                    @else
                                        @currency($fproduct->regular_price)
                                    @endif
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    <div class="space-5"></div>
    <div class="block__newsletter-wrapper">
        <div class="block-newsletter-2">
            <h3 class="block__title-2">Subscribe to our email
                newsletter and get 10% off</h3>
            <p class="h6 fs-base">Stay in the loop with the latest updates, exclusive offers, and exciting product launches
                by subscribing to our email newsletter.</p>
            <div class="block-newsletter__form-wrapper">
                <form action="" class="block-newsletter__form w-md-50">
                    <input class="form-control rounded-pill" type="email" name="email"
                        placeholder="Your email address" autocomplete="email">
                    <button class="btn btn-secondary text-white fw-medium rounded-pill" type="submit">JOIN</button>
                </form>
            </div>
        </div>
    </div>
@endsection
