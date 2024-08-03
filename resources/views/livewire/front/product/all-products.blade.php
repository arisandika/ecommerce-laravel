<section class="shop-main d-flex">
    <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
            <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
            <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>
        <div class="pt-4 pt-lg-0"></div>
        <div class="search-field__input-wrapper mb-5">
            <input type="text" name="search"
                class="search-field__input form-control form-control-sm border-light border-2 rounded-md"
                placeholder="Search" wire:model.live.debounce.500ms="search" wire:keydown="updateFilter">
        </div>
        <div class="accordion mb-4" id="categories-filters">
            <div class="accordion-item">
                <h5 class="accordion-header" id="accordion-heading-categories">
                    <button class="accordion-button p-0 border-0 fs-6" type="button" data-bs-toggle="collapse"
                        data-bs-target="#accordion-filter-categories" aria-expanded="true"
                        aria-controls="accordion-filter-categories">
                        Categories
                        <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                            <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                <path
                                    d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                            </g>
                        </svg>
                    </button>
                </h5>
                <div id="accordion-filter-categories" class="accordion-collapse collapse show border-0"
                    aria-labelledby="accordion-heading-categories" data-bs-parent="#categories-filters">
                    <div class="search-field multi-select accordion-body px-0 pt-3 pb-0">
                        <ul class="multi-select__list list-unstyled">
                            @foreach ($categories as $category)
                                <li class="search-suggestion__item">
                                    <input type="checkbox" id="category_{{ $category->name }}" class="form-check-input"
                                        wire:model="categoryFilter" wire:change="updateFilter"
                                        value="{{ $category->id }}" />
                                    <label for="category_{{ $category->name }}">
                                        {{ $category->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-list flex-grow-1">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
            <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                <a href="/" class="menu-link menu-link_us-s fw-medium">Home</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <a href="/shop" class="menu-link menu-link_us-s fw-medium">Shop</a>
                <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                <span class="menu-link menu-link_us-s fw-medium">All Product</span>
            </div>
            <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                    aria-label="Sort Items" id="sortBy" name="sortBy" wire:model="sortBy"
                    wire:change="updateFilter">
                    <option value="latest" selected="selected">Latest</option>
                    <option value="oldest">Oldest</option>
                    <option value="onsale">On Sale</option>
                    <option value="featured">Featured</option>
                    <option value="trending">Trending</option>
                    <option value="price_low_to_high">Price low to high</option>
                    <option value="price_high_to_low">Price high to low</option>
                </select>
                <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>
                <div class="col-size align-items-center order-1 d-none d-lg-flex">
                    <span class="fw-medium me-2">View</span>
                    <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                        data-cols="2">2</button>
                    <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                        data-cols="3">3</button>
                    <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                        data-cols="4">4</button>
                </div>
                <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                    <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                        data-aside="shopFilter">
                        <span class="fw-medium d-inline-block align-middle">Filter</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="products-grid row" id="products-grid">
            @forelse ($products as $product)
                <div class="col-6">
                    <div class="product-card mb-4 mb-md-5">
                        <div class="pc__img-wrapper">
                            <div class="background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="{{ url('/shop/' . $product->category->slug . '/' . $product->slug) }}">
                                            @if ($product->productImages->count() > 0)
                                                <img loading="lazy"
                                                    src="{{ Storage::url($product->productImages[0]->image) }}"
                                                    width="400" height="400" alt="{{ $product->name }}"
                                                    class="pc__img">
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pc__info position-relative">
                            <p class="pc__category">{{ $product->category->name }}</p>
                            <h6 class="pc__title mb-2"><a
                                    href="{{ url('/shop/' . $product->category->slug . '/' . $product->slug) }}">{{ $product->name }}</a>
                            </h6>
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if ($product->productSizes->count() > 0)
                                        @currency($product->productSizes->first()->size_price)
                                    @else
                                        @if ($product->sale_price > 0)
                                            @currency($product->sale_price)
                                        @else
                                            @currency($product->regular_price)
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="space-4"></div>
                    <p>No product available.</p>
                    <div class="space-4"></div>
                </div>
            @endforelse
        </div>
        {{ $products->links() }}
    </div>
</section>
