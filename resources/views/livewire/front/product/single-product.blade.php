<section class="product-single product-single__type-6">
    <div class="row">
        <div class="col-lg-6">
            <div class="product-single__media" data-media-type="list-image">
                <div class="product-single__image d-flex flex-column gap-2">
                    @if ($productImages && $productImages->isNotEmpty())
                        @foreach ($productImages as $pimage)
                            <div class="product-single__image-item">
                                <img loading="lazy" class="product__img h-auto w-auto"
                                    src="{{ Storage::url($pimage->image) }}" width="700" height="700"
                                    alt="{{ $pimage->name }}">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="sticky-content product-single__wrapper">
                <div class="breadcrumb mb-2 flex-grow-1">
                    <a href="/shop" class="menu-link menu-link_us-s fw-medium">Shop</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="/shop/{{ $category->slug }}"
                        class="menu-link menu-link_us-s fw-medium">{{ $product->category->name }}</a>
                </div>
                <h1 class="product-single__name">{{ $product->name }}</h1>
                <div class="product-single__price">
                    <span class="current-price">
                        @if ($product->productSizes->count() > 0)
                            @if ($sizeSelectedPrice)
                                <div class="skeleton__placeholder w-25" wire:loading wire:target="sizeSelected">
                                </div>
                                <span wire:loading.remove wire:target="sizeSelected">
                                    @currency($sizeSelectedPrice)</span>
                            @endif
                        @else
                            @if ($product->sale_price > 0)
                                @currency($product->sale_price)
                            @else
                                @currency($product->regular_price)
                            @endif
                        @endif
                    </span>
                </div>
                <div class="product-single__short-desc">
                    <p>{{ $product->short_description }}</p>
                </div>
                <div class="product-single__stock">
                    @if ($product->productSizes->count() > 0)
                        @if ($this->sizeSelectedQuantity == 'outOfStock')
                            <div class="badge badge-secondary" wire:loading.remove wire:target="sizeSelected">Out of
                                Stock</div>
                        @elseif ($this->sizeSelectedQuantity > 0)
                            <div class="badge badge-secondary" wire:loading.remove wire:target="sizeSelected">Product in
                                Stock ({{ $sizeQuantity }})</div>
                        @endif
                        <div class="skeleton__placeholder w-25" wire:loading wire:target="sizeSelected">
                        </div>
                    @else
                        @if ($product->quantity)
                            <div class="badge badge-secondary">Product in Stock
                                ({{ $product->quantity }})</div>
                        @else
                            <div class="badge badge-secondary">Out of Stock
                            </div>
                        @endif
                    @endif
                </div>
                @if ($product->productSizes->isNotEmpty())
                    <div class="product-single__swatches">
                        <div class="product-swatch text-swatches">
                            <span>Sizes</span>
                            <div class="swatch-list">
                                @foreach ($product->productSizes as $index => $psize)
                                    <input type="radio" name="size" id="swatch-{{ $psize->id }}"
                                        {{ $index === 0 ? 'checked' : '' }}>
                                    <label class="swatch js-swatch" for="swatch-{{ $psize->id }}"
                                        aria-label="{{ $psize->size->name }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $psize->size->name }}"
                                        x-on:click="$wire.sizeSelected('{{ $psize->id }}')">{{ $psize->size->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="product-single__addtocart">
                    <div class="qty-control position-relative">
                        <input type="number" name="quantity" value="{{ $this->quantityCount }}"
                            class="qty-control__number text-center rounded-pill" readonly wire:model="quantityCount"
                            wire:loading.target="addToCart">
                        <button type="button" class="btn qty-control__reduce" wire:click="decrementQuantity"
                            {{ $this->quantityCount == 1 ? 'disabled' : '' }}>-</button>
                        <button type="button" class="btn qty-control__increase"
                            wire:click="incrementQuantity">+</button>
                    </div>
                    <button type="button" class="btn btn-primary rounded-pill btn-addtocart"
                        x-on:click="$wire.addToCart('{{ $product->id }}')">
                        <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                        <span wire:loading wire:target="addToCart">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </span>
                    </button>
                </div>
                <div class="space-4"></div>
                <div id="product_single_details_accordion" class="product-single__details-accordion accordion">
                    <div class="accordion-item">
                        <h6 class="accordion-header h6" id="accordion-heading-1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-collapse-1" aria-expanded="true"
                                aria-controls="accordion-collapse-1">
                                Description
                                <svg class="accordion-button__icon" viewBox="0 0 14 14">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path class="svg-path-vertical" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                        <path class="svg-path-horizontal" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                    </g>
                                </svg>
                            </button>
                        </h6>
                        <div id="accordion-collapse-1" class="accordion-collapse collapse show"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#product_single_details_accordion">
                            <div class="accordion-body">
                                <div class="product-single__description">
                                    <pre class="content">{{ $product->description }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h6 class="accordion-header h6" id="accordion-heading-2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-collapse-2" aria-expanded="false"
                                aria-controls="accordion-collapse-2">
                                Additional Information
                                <svg class="accordion-button__icon" viewBox="0 0 14 14">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path class="svg-path-vertical" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                        <path class="svg-path-horizontal" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                    </g>
                                </svg>
                            </button>
                        </h6>
                        <div id="accordion-collapse-2" class="accordion-collapse collapse"
                            aria-labelledby="accordion-heading-2" data-bs-parent="#product_single_details_accordion">
                            <div class="accordion-body">
                                <div class="product-single__addtional-info">
                                    <div class="item">
                                        <h6 class="h6">Weight</h6>
                                        <span>{{ $product->weight }} Kg</span>
                                    </div>
                                    <div class="item">
                                        <h6 class="h6">Dimensions</h6>
                                        <span>90 x 60 x 90 cm</span>
                                    </div>
                                    <div class="item">
                                        <h6 class="h6">Storage</h6>
                                        @foreach ($product->productSizes as $index => $psize)
                                            <span>{{ $psize->size->name }}, </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h6 class="accordion-header h6" id="accordion-heading-3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-collapse-3" aria-expanded="false"
                                aria-controls="accordion-collapse-3">
                                Warranty
                                <svg class="accordion-button__icon" viewBox="0 0 14 14">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path class="svg-path-vertical" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                        <path class="svg-path-horizontal" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                    </g>
                                </svg>
                            </button>
                        </h6>
                        <div id="accordion-collapse-3" class="accordion-collapse collapse"
                            aria-labelledby="accordion-heading-3" data-bs-parent="#product_single_details_accordion">
                            <div class="accordion-body">
                                <div class="product-single__description">
                                    <p class="content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus
                                        pariatur voluptatem labore iusto libero esse quo culpa neque animi hic maxime
                                        magni amet expedita sunt repudiandae nihil beatae harum aliquid aut doloremque,
                                        laboriosam temporibus reiciendis non inventore. Tempora neque error earum
                                        provident, assumenda perspiciatis magnam pariatur laborum ullam dolorem sed.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h6 class="accordion-header h6" id="accordion-heading-4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-collapse-4" aria-expanded="false"
                                aria-controls="accordion-collapse-4">
                                Shipping & Delivery
                                <svg class="accordion-button__icon" viewBox="0 0 14 14">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path class="svg-path-vertical" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                        <path class="svg-path-horizontal" d="M14,6 L14,8 L0,8 L0,6 L14,6"></path>
                                    </g>
                                </svg>
                            </button>
                        </h6>
                        <div id="accordion-collapse-4" class="accordion-collapse collapse"
                            aria-labelledby="accordion-heading-4" data-bs-parent="#product_single_details_accordion">
                            <div class="accordion-body">
                                <div class="product-single__description">
                                    <p class="content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea,
                                        voluptates! Ea, voluptatibus inventore. Illum fugit ipsa minus praesentium,
                                        consequuntur ratione?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
