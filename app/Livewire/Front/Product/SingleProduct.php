<?php

namespace App\Livewire\Front\Product;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SingleProduct extends Component
{
    public $category, $product, $productImages, $quantityCount = 1, $productId, $sizeQuantity, $sizePrice, $sizeSelectedQuantity, $sizeSelectedPrice, $productSizeId;

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
        $this->loadProductImages();

        if ($this->product->productSizes->isNotEmpty()) {
            $firstSize = $this->product->productSizes->first();
            $this->sizeSelected($firstSize->id);
        }
    }

    public function sizeSelected($productSizeId)
    {
        $this->productSizeId = $productSizeId;

        $productSize = $this->product->productSizes()->where('id', $productSizeId)->first();
        $this->sizeQuantity = $productSize->quantity;
        $this->sizePrice = $productSize->price;

        $this->sizeSelectedQuantity = $productSize->quantity;
        $this->sizeSelectedPrice = $productSize->size_price;

        if ($this->sizeSelectedQuantity == 0) {
            $this->sizeSelectedQuantity == 'outOfStock';
        }
    }

    public function render()
    {
        return view('livewire.front.product.single-product', [
            'category' => $this->category,
            'product' => $this->product,
            'productImages' => $this->productImages,
        ]);
    }

    private function loadProductImages()
    {
        // Memuat gambar produk menggunakan Eloquent Relationship
        $this->productImages = ProductImage::where('product_id', $this->product->id)->get();
    }

    public function incrementQuantity()
    {
        // Ambil nilai maksimum quantity dari produk
        $maxQuantity = $this->product->quantity;

        // Cek apakah quantityCount sudah mencapai nilai maksimum
        if ($this->quantityCount < $maxQuantity) {
            $this->quantityCount++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }
    }

    public function addToCart($productId)
    {
        // Simpan URL halaman produk sebelumnya dalam sesi
        Session::put('previous_product_page', url()->previous());

        if (Auth::check()) {
            $user = auth()->user();
            $product = Product::where('id', $productId)
                ->where('visibility', '0')
                ->first();

            if ($product) {
                if ($product->productSizes()->count() > 1) {

                    if ($this->sizeSelectedQuantity != NULL) {
                        // dd('sizes dipilih');

                        $productSize = $this->product->productSizes()->where('id', $this->productSizeId)->first();

                        if ($productSize->quantity > 0) {
                            // Check if the product already exists in the user's cart
                            $existingCartItem = Cart::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->where('product_size_id', $productSize->id)
                                ->first();

                            if ($existingCartItem) {
                                // If the product already exists in the cart with the same size, increase the quantity
                                $newQuantity = $existingCartItem->quantity + $this->quantityCount;

                                // Ensure that the quantity doesn't exceed the product stock
                                if ($newQuantity <= $productSize->quantity) {
                                    $existingCartItem->update(['quantity' => $newQuantity]);

                                    $this->dispatch('CartAddedUpdated');

                                    $this->dispatch(
                                        'message',
                                        text: 'Product successfully added to cart.',
                                        status: 200,
                                    );
                                } else {
                                    $this->dispatch(
                                        'message',
                                        text: 'Sorry, only ' . $productSize->quantity . ' items available for this size.',
                                        status: 404,
                                    );
                                }
                            } else {
                                // If the product doesn't exist in the cart with the same size, add it
                                Cart::create([
                                    'user_id' => $user->id,
                                    'product_id' => $productId,
                                    'product_size_id' => $productSize->id,
                                    'quantity' => $this->quantityCount,
                                ]);

                                $this->dispatch('CartAddedUpdated');

                                $this->dispatch(
                                    'message',
                                    text: 'Product successfully added to cart.',
                                    status: 200,
                                );
                            }
                        } else {
                            $this->dispatch(
                                'message',
                                text: 'Sorry, product size is currently out of stock.',
                                status: 404,
                            );
                        }

                    } else {
                        $this->dispatch(
                            'message',
                            text: 'Select your product size',
                            status: 404,
                        );
                    }

                } else {
                    // tanpa size

                    if ($product->quantity > 0) {
                        // Check if the product already exists in the user's cart
                        $existingCartItem = Cart::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

                        if ($existingCartItem) {
                            // If the product already exists in the cart, increase the quantity
                            $newQuantity = $existingCartItem->quantity + $this->quantityCount;

                            // Ensure that the quantity doesn't exceed the product stock
                            if ($newQuantity <= $product->quantity) {
                                $existingCartItem->update(['quantity' => $newQuantity]);

                                $this->dispatch('CartAddedUpdated');

                                $this->dispatch(
                                    'message',
                                    text: 'Product successfully added to cart.',
                                    status: 200,
                                );
                            } else {
                                $this->dispatch(
                                    'message',
                                    text: 'Sorry, only ' . $product->quantity . ' items available.',
                                    status: 404,
                                );
                            }
                        } else {
                            // If the product doesn't exist in the cart, add it
                            Cart::create([
                                'user_id' => $user->id,
                                'product_id' => $productId,
                                'quantity' => $this->quantityCount,
                            ]);

                            $this->dispatch('CartAddedUpdated');

                            $this->dispatch(
                                'message',
                                text: 'Product successfully added to cart.',
                                status: 200,
                            );
                        }
                    } else {
                        $this->dispatch(
                            'message',
                            text: 'Sorry, product is currently out of stock.',
                            status: 404,
                        );
                    }
                }
            } else {
                $this->dispatch(
                    'message',
                    text: 'Sorry, we could not find the product.',
                    status: 500,
                );
            }
        } else {
            // Jika pengguna belum login/register, arahkan ke halaman login
            return redirect('register');
        }
    }

}
