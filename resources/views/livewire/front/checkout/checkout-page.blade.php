<section class="shop-checkout">
    <form name="checkout-form" action="https://uomo-html.flexkitux.com/Demo9/shop_order_complete.html">
        <div class="row">
            <div class="col-lg-7 billing-info__wrapper">
                <div class="row">
                    <h6 class="billing-info__title">Contact</h6>
                    <div class="col-md-12">
                        <div class="form-floating my-2">
                            <input id="fullname" name="fullname" type="text" class="form-control"
                                placeholder="Full Name *" wire:model.defer="fullname">
                            <label for="fullname">Full Name</label>
                            @error('fullname')
                                <small class="text-invalid">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-2">
                            <input id="email" name="email" type="email" class="form-control"
                                placeholder="Your Mail *" wire:model.defer="email">
                            <label for="email">Email *</label>
                            @error('email')
                                <small class="text-invalid">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-2">
                            <input id="phone" name="phone" type="text" class="form-control"
                                placeholder="Phone *" wire:model.defer="phone">
                            <label for="phone">Phone *</label>
                            @error('phone')
                                <small class="text-invalid">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <h6 class="billing-info__title-2">Address</h6>
                    <div class="col-md-12">
                        <div class="form-floating my-2">
                            <select name="provinsi" class="form-select" wire:model.change="provinsi_id">
                                <option>Choose a province *</option>
                                @forelse ($daftarProvinsi as $province)
                                    <option value="{{ $province['province_id'] }}">{{ $province['province'] }}
                                    </option>
                                @empty
                                    <option>Province not found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-2">
                            <select name="kota" class="form-select" wire:model.change="kota_id"
                                wire:target="provinsi_id" wire:loading.attr="disabled">
                                <option>Town / City *</option>
                                @if ($provinsi_id)
                                    @forelse ($daftarKota as $city)
                                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                    @empty
                                        <option>City not found</option>
                                    @endforelse
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating my-2">
                            <input id="postcode" name="postcode" type="text" class="form-control"
                                placeholder="Postcode / ZIP *" wire:model.defer="postcode">
                            <label for="postcode">Postcode / ZIP *</label>
                            @error('postcode')
                                <small class="text-invalid">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating my-2">
                            <input id="address" name="address" type="text" class="form-control" id="address"
                                placeholder="Street Address *" wire:model.defer="address">
                            <label for="address">Street Address *</label>
                            @error('address')
                                <small class="text-invalid">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mt-2">
                            <select name="jasa" class="form-select" wire:model.change="jasa"
                                @if (!$provinsi_id || !$kota_id) disabled @endif>
                                <option>Choose courier *</option>
                                <option value="jne">JNE</option>
                                <option value="pos">Pos Indonesia</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkout__delivery row">
                            <div class="billing-info__title-3">
                                <h6 class="mb-1">Shipping Methods</h6>
                                <span>Choose from a variety of shipping options to meet your delivery needs.</span>
                            </div>
                            @if ($results)
                                @foreach ($results as $index => $result)
                                    <div class="col-md-6" wire:loading.remove wire:target="provinsi_id, kota_id, jasa">
                                        <div class="form-check">
                                            <input id="radio_{{ $index }}" type="radio"
                                                class="form-check-input form-check-input_fill" name="selected_jasa"
                                                wire:click="saveOngkir({{ $result['biaya'] }})">
                                            <label class="form-check-label" for="radio_{{ $index }}">
                                                <strong>
                                                    {{ $nama_jasa }}
                                                </strong>
                                                <span class="option-detail d-block">
                                                    {{ $result['description'] }}.
                                                    <br>
                                                    @currency($result['biaya'])
                                                    <br>
                                                    Estimasi Pengiriman {{ $result['etd'] }} Hari.
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12" wire:loading.remove wire:target="jasa, provinsi_id, kota_id">
                                    <div class="alert-shipping">
                                        Enter your shipping address to view available shipping methods.
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12" wire:loading wire:target="jasa, provinsi_id, kota_id">
                                <div class="skeleton__placeholder mb-05"></div>
                                <div class="skeleton__placeholder mb-05"></div>
                                <div class="skeleton__placeholder mb-05"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkout__payment-methods row">
                            <div class="billing-info__title-4">
                                <h6 class="mb-1">Payment Methods</h6>
                                <span>All transactions are secure and encrypted.</span>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input form-check-input_fill"
                                        name="payment_method" id="direct_bank_transfer" checked>
                                    <label class="form-check-label" for="direct_bank_transfer">
                                        <strong>Payments by Midtrans</strong>
                                        <span class="option-detail d-block">
                                            Make your payment directly into our bank account. Please use your Order ID
                                            as
                                            the payment reference.
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 checkout__totals-wrapper">
                @if ($subTotalPrice > 0)
                    <div class="sticky-content">
                        <div class="checkout__totals rounded-lg">
                            <h3 class="text-center fw-bold">Your Order</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $cartItem)
                                        <tr>
                                            <td>
                                                {{ $cartItem->product->name }} x {{ $cartItem->quantity }}
                                            </td>
                                            <td>
                                                @if ($cartItem->product->productSizes->count() > 0)
                                                    @currency($cartItem->productSize->size_price)
                                                @else
                                                    @if ($cartItem->product->sale_price > 0)
                                                        @currency($cartItem->product->sale_price)
                                                    @else
                                                        @currency($cartItem->product->regular_price)
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td>@currency($subTotalPrice)</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td>
                                            <span wire:loading.remove
                                                wire:target="saveOngkir, provinsi_id, kota_id">@currency($selectedShippingCost)</span>
                                            <div class="skeleton__placeholder" wire:loading
                                                wire:target="saveOngkir, provinsi_id, kota_id">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td>
                                            <span wire:loading.remove
                                                wire:target="saveOngkir, provinsi_id, kota_id">@currency($totalPriceWithShipping)</span>
                                            <div class="skeleton__placeholder" wire:loading
                                                wire:target="saveOngkir, provinsi_id, kota_id">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="space-3"></div>
                            <button type="button" class="btn btn-primary btn-checkout rounded-pill"
                                wire:click="payment">
                                <span wire:loading.remove wire:target="payment">Place Order</span>
                                <span wire:loading wire:target="payment">
                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                </span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="sticky-content">
                        <div class="checkout__totals rounded-lg">
                            <table class="checkout-totals">
                                <tbody>
                                    <tr class="empty-cart">
                                        <td colspan="6" class="text-center w-100">
                                            <div class="cart-img">
                                                <img src="/front/images/cart.png" alt="cart">
                                            </div>
                                            <p>Your cart is currently empty. <br> <a href="/shop">Start shopping
                                                    now!</a>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>
