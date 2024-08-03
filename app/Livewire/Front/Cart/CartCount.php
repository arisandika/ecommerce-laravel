<?php

namespace App\Livewire\Front\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount;

    protected $listener = ['CartAddedUpdated' => 'checkCartCount'];

    public function checkCartCount()
    {
        if (Auth::check()) {
            return $this->cartCount = Cart::where('user_id', auth()->user()->id)->sum('quantity');
        } else {
            return $this->cartCount = 0;
        }
    }

    #[On('CartAddedUpdated')]
    public function render()
    {
        $this->cartCount = $this->checkCartCount();
        return view('livewire.front.cart.cart-count', [
            'cartCount' => $this->cartCount
        ]);
    }
}