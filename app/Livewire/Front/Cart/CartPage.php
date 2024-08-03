<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartPage extends Component
{
    public $cart, $totalPrice = 0;

    public function decrementQuantity($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();

        if ($cartData) {
            if ($cartData->quantity > 1) {
                $cartData->decrement('quantity');

                $this->dispatch('CartAddedUpdated');

                $this->dispatch(
                    'message',
                    text: 'Your cart has been updated successfully.',
                    status: 200,
                );
            } else {
                $this->dispatch(
                    'message',
                    text: 'Sorry, quantity cannot be less than 1.',
                    status: 404,
                );
            }
        } else {
            $this->dispatch(
                'message',
                text: 'Sorry, item in the cart could not be found.',
                status: 500,
            );
        }

    }

    public function incrementQuantity($cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();

        if ($cartData) {
            // Check if incrementing the quantity exceeds the product stock
            $product = $cartData->product;

            if ($cartData->productSize()->where('id', $cartData->product_size_id)->exists()) {
                $productSize = $cartData->productSize()->where('id', $cartData->product_size_id)->first();

                if ($productSize->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');

                    $this->dispatch('CartAddedUpdated');

                    $this->dispatch(
                        'message',
                        text: 'Your cart has been updated successfully.',
                        status: 200,
                    );
                } else {
                    $this->dispatch(
                        'message',
                        text: 'Sorry, product quantity stock limit has been reached.',
                        status: 404,
                    );
                }
            } else {
                if ($product && $cartData->quantity < $product->quantity) {
                    $cartData->increment('quantity');

                    $this->dispatch('CartAddedUpdated');

                    $this->dispatch(
                        'message',
                        text: 'Your cart has been updated successfully.',
                        status: 200,
                    );
                } else {
                    $this->dispatch(
                        'message',
                        text: 'Sorry, product quantity stock limit has been reached.',
                        status: 404,
                    );
                }
            }


        } else {
            $this->dispatch(
                'message',
                text: 'Sorry, item in the cart could not be found.',
                status: 500,
            );
        }
    }

    public function removeCartItem($cartId)
    {
        $cartRemoveData = Cart::where('user_id', auth()->user()->id)->where('id', $cartId)->first();

        if ($cartRemoveData) {
            $cartRemoveData->delete();

            $this->dispatch('CartAddedUpdated');

            $this->dispatch(
                'message',
                text: 'Product successfully removed from your cart.',
                status: 200,
            );
        } else {
            $this->dispatch(
                'message',
                text: 'Sorry, item in the cart could not be found.',
                status: 500,
            );
        }
    }

    public function render()
    {
        if (auth()->check()) {
            $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        } else {
            // Jika pengguna tidak masuk, dapatkan keranjang untuk tamu (guest)
            $this->cart = Cart::where('user_id', null)->get();
        }

        return view('livewire.front.cart.cart-page', [
            'cart' => $this->cart,
        ]);
    }

}
