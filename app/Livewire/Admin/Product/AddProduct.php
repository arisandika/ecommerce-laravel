<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use WithFileUploads;

    public $category_id, $name, $slug, $brand, $short_description, $description, $regular_price, $sale_price, $quantity, $weight, $sale = 0, $stock = 0, $trending, $featured, $visibility, $meta_title, $meta_keyword, $meta_description, $image, $images, $size, $sizes, $isChecked, $size_price;
    public $sizeTypes = [];
    public $sizeQuantity = [];
    public $sizePrice = [];

    public function rules()
    {
        return [
            'category_id' => 'required',
            'name' => 'required|string',
            'slug' => 'required|string',
            'brand' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'regular_price' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'quantity' => 'nullable|integer|min:0',
            'weight' => 'required|integer',
            'trending' => 'nullable|integer',
            'featured' => 'nullable|integer',
            'visibility' => 'nullable|integer',
            'meta_title' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ];
    }

    public function updated()
    {
        $this->updatedQuantity($this->quantity);
        $this->updatedSalePrice($this->sale_price);
    }

    public function updatedQuantity($value)
    {
        // Jika quantity lebih dari 0, set stock ke "In Stock"
        $this->stock = $value > 0 ? 0 : 1;
    }

    public function updatedSalePrice($value)
    {
        // Jika sale price lebih dari 0, set sale status ke "In Sale"
        $this->sale = $value > 0 ? 0 : 1;
    }

    public function store()
    {
        $this->validate();

        $brand = $this->brand ?: 'No brand';

        $sale_price = $this->sale_price !== '' ? (int) $this->sale_price : 0;
        $quantity = $this->quantity !== '' ? (int) $this->quantity : 0;

        // Create the product with validated data
        $category = Category::findOrFail($this->category_id);

        $product = $category->products()->create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'brand' => $brand,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'regular_price' => $this->regular_price,
            'sale_price' => $sale_price,
            'quantity' => $quantity,
            'weight' => $this->weight,
            'trending' => $this->trending ? '1' : '0',
            'featured' => $this->featured ? '1' : '0',
            'visibility' => $this->visibility ? '1' : '0',
            'meta_title' => $this->meta_title,
            'meta_keyword' => $this->meta_keyword,
            'meta_description' => $this->meta_description,
        ]);

        // Process multiple images if available
        if ($this->images) {
            foreach ($this->images as $image) {
                // Simpan gambar
                $path = $image->store('public/uploads/images/products');

                // Buat entri ProductImage
                $product->productImages()->create([
                    'image' => $path,
                ]);
            }
        }

        if ($this->sizeTypes) {
            foreach ($this->sizeTypes as $sizeId => $isChecked) {
                // Jika kotak centang ukuran dicentang
                if ($isChecked) {
                    // Simpan entri productSizes
                    $product->productSizes()->create([
                        'product_id' => $product->id,
                        'size_id' => $sizeId,
                        'quantity' => $this->sizeQuantity[$sizeId] ?? 0,
                        'size_price' => $this->sizePrice[$sizeId] ?? 0,
                    ]);
                }
            }
        }

        session()->flash('message', 'Product added successfully.');

        return $this->redirect('/admin/products', navigate: true);
    }

    public function render()
    {
        $categories = Category::all();
        $sizesOption = Size::all();
        return view('livewire.admin.product.add', compact('categories', 'sizesOption'))
            ->extends('livewire.layouts.admin')
            ->section('content');
    }
}
