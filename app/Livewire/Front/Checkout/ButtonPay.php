<?php

namespace App\Livewire\Front\Checkout;

use Livewire\Attributes\On;
use Livewire\Component;

class ButtonPay extends Component
{
    public $payment;

    // Metode untuk menangkap event
    protected $listeners = ['paymentProcessed'];

    public function paymentProcessed($payment)
    {
        // Mengatur data $payment yang diterima dari event
        $this->payment = $payment;
    }

    #[On('paymentProcessed')]
    public function render()
    {
        return view('livewire.front.checkout.button-pay');
    }
}
