<?php

namespace App\Livewire\Front\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\RajaOngkir;
use Livewire\Component;

class CheckoutPage extends Component
{
    private $apiKey;
    public $provinsi_id, $kota_id, $jasa, $daftarProvinsi, $daftarKota, $nama_jasa, $results;
    public $cart, $subTotalPrice = 0, $weight, $totalHarga;
    public $selectedShippingCost = 0, $totalPriceWithShipping;
    public $id, $user_id, $tracking_no, $fullname, $email, $phone, $postcode, $address, $subtotal_price, $shipping_cost, $total_price, $status_order, $payment_method = NULL, $payment_id = NULL;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.apiKey');
    }

    public function mount()
    {
        if (!Auth::user()) {
            return redirect('/login');
        }

        $this->cart = Cart::where('user_id', auth()->user()->id)->get();

        if ($this->cart->isEmpty()) {
            return redirect('/');
        }

        // Calculate total price
        foreach ($this->cart as $cartItem) {
            if ($cartItem->product->productSizes->count() > 0) {
                $this->subTotalPrice += $cartItem->productSize->size_price * $cartItem->quantity;
            }

            if ($cartItem->product->sale_price > 0) {
                $this->subTotalPrice += $cartItem->product->sale_price * $cartItem->quantity;
            } else {
                $this->subTotalPrice += $cartItem->product->regular_price * $cartItem->quantity;
            }
        }
    }

    public function updatedProvinsiId()
    {
        $this->resetSelection();
        $this->getOngkir();
    }

    public function updatedKotaId()
    {
        $this->resetSelectionKota();
        $this->getOngkir();
    }

    public function updatedJasa()
    {
        $this->resetSelectionJasa();
        $this->getOngkir();
    }

    public function getOngkir()
    {
        // Check if all required fields are present
        if (!$this->provinsi_id || !$this->kota_id || !$this->jasa) {
            return;
        }

        $weight = 0; // Initialize weight
        foreach ($this->cart as $item) {
            $product = Product::find($item->product_id);
            $weight += $product->weight * $item->quantity; // Add product weight multiplied by quantity to total weight
        }

        $rajaOngkir = new RajaOngkir($this->apiKey);

        try {
            $cost = $rajaOngkir->ongkosKirim([
                'origin' => 456, // ID kota Tangerang
                'destination' => $this->kota_id, // ID kota/kabupaten tujuan
                'weight' => $weight, // Berat total dalam gram
                'courier' => $this->jasa // Kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ])->get();

            $this->nama_jasa = $cost[0]['name'];

            foreach ($cost[0]['costs'] as $row) {
                $this->results[] = array(
                    'description' => $row['description'],
                    'biaya' => $row['cost'][0]['value'],
                    'etd' => $row['cost'][0]['etd'],
                );
            }
        } catch (\Exception) {
            $this->dispatch(
                'message',
                text: 'Your cart is empty, go shop now.',
                status: 404,
            );
        }
    }

    public function saveOngkir($shipping_cost)
    {
        // Calculate price shipping
        $this->selectedShippingCost = $shipping_cost;

        // Calculate total price including shipping
        $this->totalPriceWithShipping = $this->subTotalPrice + $this->selectedShippingCost;
    }

    public function resetSelection()
    {
        $this->kota_id = null;
        $this->jasa = null;
        $this->results = null;
        $this->selectedShippingCost = 0;
        $this->totalPriceWithShipping = 0;
    }

    public function resetSelectionKota()
    {
        $this->jasa = null;
        $this->results = null;
        $this->selectedShippingCost = 0;
        $this->totalPriceWithShipping = 0;
    }

    public function resetSelectionJasa()
    {
        $this->results = null;
        $this->selectedShippingCost = 0;
        $this->totalPriceWithShipping = 0;
    }

    public function render()
    {
        $rajaOngkir = new RajaOngkir((string) $this->apiKey);
        $this->daftarProvinsi = $rajaOngkir->provinsi()->all();

        if ($this->provinsi_id) {
            $this->daftarKota = $rajaOngkir->kota()->dariProvinsi($this->provinsi_id)->get();
        }

        return view('livewire.front.checkout.checkout-page', [
            'cart' => $this->cart,
            'selectedShippingCost' => $this->selectedShippingCost,
            'totalPriceWithShipping' => $this->totalPriceWithShipping,
        ]);
    }

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|string|max:15|min:10',
            'postcode' => 'required|string|max:6|min:4',
            'address' => 'required|string|max:500',
        ];
    }

    public function placeOrder()
    {
        $this->validate();

        // Validate the required fields
        if (!$this->selectedShippingCost || !$this->totalPriceWithShipping) {
            $this->dispatch(
                'message',
                text: 'Please check your address and try again.',
                status: 404,
            );
            return;
        }

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'tracking_no' => 'STC' . random_int(100000000, 999999999),
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'postcode' => $this->postcode,
            'address' => $this->address,
            'subtotal_price' => $this->subTotalPrice,
            'shipping_cost' => $this->selectedShippingCost,
            'total_price' => $this->totalPriceWithShipping,
            'status_order' => 'Pending',
            'payment_method' => $this->payment_method,
            'payment_id' => $this->payment_id,
        ]);

        foreach ($this->cart as $cartItem) {
            // Calculate the price based on whether there is a sale or not
            $price = $cartItem->product->sale_price > 0 ? $cartItem->product->sale_price : $cartItem->product->regular_price;

            if ($cartItem->product->productSizes->count() > 0) {
                // If the product has sizes, use the size_price if available
                $price = $cartItem->productSize->size_price ?? $price;
            }

            // Create the order detail
            $orderDetails = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_size_id' => $cartItem->product_size_id,
                'quantity' => $cartItem->quantity,
                'price' => $price,
            ]);
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $this->totalPriceWithShipping,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $order->snap_token = $snapToken;

        $order->save();

        return $order;
    }

    public function payment()
    {
        $this->payment_method = 'Midtrans';
        $payment = $this->placeOrder();

        if ($payment) {
            Cart::where('user_id', auth()->user()->id)->delete();
            $this->dispatch('CartAddedUpdated');
            $this->dispatch(
                'message',
                text: 'Your order has been placed successfully.',
                status: 200,
            );
            return redirect()->route('checkout.paynow', $payment->id);
            // return redirect()->route('checkout.success', ['id' => $payment->id]);
        } else {
            $this->dispatch(
                'message',
                text: 'Something went wrong.',
                status: 500,
            );
            return redirect()->back()->with('error', 'Something went wrong while placing the order.');
        }
    }
}
