<section class="shop-checkout">
    <div class="row shopping-cart">
        <div class="col-md-8 cart-table__wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th colspan="2">Product</th>
                        <th>Quantity</th>
                        <th colspan="2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cart as $cartItem)
                        @if ($cartItem->product)
                            <tr>
                                <td>
                                    <a
                                        href="{{ url('shop/' . $cartItem->product->category->slug . '/' . $cartItem->product->slug) }}">
                                        <div class="shopping-cart__product-item">
                                            @if ($cartItem->product->productImages)
                                                <img loading="lazy"
                                                    src="{{ Storage::url($cartItem->product->productImages[0]->image) }}"
                                                    class="bg__img" width="120" height="120"
                                                    alt="{{ $cartItem->product->name }}">
                                            @else
                                                No img
                                            @endif
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div class="shopping-cart__product-item__detail">
                                        <h6>{{ $cartItem->product->name }}</h6>
                                        <ul class="shopping-cart__product-item__options">
                                            @if ($cartItem->productSize)
                                                <li>
                                                    <div class="mb-1">
                                                        <span class="shopping-cart__size">Size : </span>
                                                        <div class="badge badge-secondary">
                                                            {{ $cartItem->productSize->size->name }}</div>
                                                    </div>
                                                </li>
                                            @endif
                                            <li>
                                                <span class="shopping-cart__price">
                                                    @if ($cartItem->product->productSizes->count() > 0)
                                                        @currency($cartItem->productSize->size_price)
                                                    @else
                                                        @if ($cartItem->product->sale_price > 0)
                                                            @currency($cartItem->product->sale_price)
                                                        @else
                                                            @currency($cartItem->product->regular_price)
                                                        @endif
                                                    @endif
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="qty-control position-relative">
                                        <input id="quantity" name="quantity" type="number"
                                            value="{{ $cartItem->quantity }}" min="1"
                                            class="qty-control__number text-center" readonly>
                                        <button type="button" class="btn qty-control__reduce"
                                            x-on:click="$wire.decrementQuantity('{{ $cartItem->id }}')"
                                            wire:loading.attr="disabled"{{ $cartItem->quantity <= 1 ? ' disabled' : '' }}>-</button>
                                        <button type="button" class="btn qty-control__increase"
                                            x-on:click="$wire.incrementQuantity('{{ $cartItem->id }}')"
                                            wire:loading.attr="disabled"
                                            {{ ($cartItem->quantity >= $cartItem->product->quantity && !$cartItem->productSize) ||
                                            ($cartItem->productSize && $cartItem->quantity >= $cartItem->productSize->quantity)
                                                ? ' disabled'
                                                : '' }}>+</button>
                                    </div>
                                </td>
                                <td>
                                    <div class="skeleton__placeholder" wire:loading
                                        wire:target="decrementQuantity, incrementQuantity">
                                    </div>
                                </td>
                                <td>
                                    <span class="shopping-cart__subtotal">
                                        @if ($cartItem->product->productSizes->count() > 0)
                                            <span wire:loading.remove
                                                wire:target="decrementQuantity, incrementQuantity">@currency($cartItem->productSize->size_price * $cartItem->quantity)</span>
                                        @else
                                            @if ($cartItem->product->sale_price > 0)
                                                <span wire:loading.remove
                                                    wire:target="decrementQuantity, incrementQuantity">@currency($cartItem->product->sale_price * $cartItem->quantity)</span>
                                            @else
                                                <span wire:loading.remove
                                                    wire:target="decrementQuantity, incrementQuantity">@currency($cartItem->product->regular_price * $cartItem->quantity)</span>
                                            @endif
                                        @endif
                                        @php
                                            $totalPrice += $cartItem->product->regular_price * $cartItem->quantity;
                                            $totalPrice += $cartItem->product->sale_price * $cartItem->quantity;

                                            if ($cartItem->product->productSizes->count() > 0) {
                                                $totalPrice += $cartItem->productSize->size_price * $cartItem->quantity;
                                            }
                                        @endphp
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn-remove remove-cart"
                                        x-on:click="$wire.removeCartItem('{{ $cartItem->id }}')"
                                        wire:loading.attr="disabled">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                            <path
                                                d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr class="empty-cart">
                            <td colspan="6" class="text-center w-100">
                                <div class="cart-img">
                                    <img src="/front/images/cart.png" alt="">
                                </div>
                                <p>Your cart is currently empty. <br> <a href="/shop">Start shopping now!</a>
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($totalPrice > 0)
            <div class="col-md-4 shopping-cart__totals-wrapper text-end">
                <div class="sticky-content">
                    <div class="shopping-cart__totals rounded-lg">
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th><span>total</span></th>
                                    <td>
                                        <span wire:loading.remove
                                            wire:target="decrementQuantity, incrementQuantity">@currency($totalPrice)</span>
                                        <div class="skeleton__placeholder w-50" wire:loading
                                            wire:target="decrementQuantity, incrementQuantity">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>Taxes and shipping calculated at checkout</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="space-2"></div>
                        <div class="mobile_fixed-btn_wrapper">
                            <a href="{{ url('/checkout') }}" id="checkoutBtn"
                                class="btn btn-primary btn-checkout rounded-pill">
                                <span id="checkoutText">Proceed to Checkout</span>
                                <div id="spinner" class="spinner-border spinner-border-sm visually-hidden"
                                    role="status">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('checkoutBtn').addEventListener('click', function(event) {

                document.getElementById('spinner').classList.remove('visually-hidden');
                document.getElementById('checkoutText').innerText = '';

                setTimeout(function() {
                    window.location.href = "/checkout";
                }, 5000);
            });
        });
    </script>
@endpush
