<?php

namespace App\Livewire\Admin\Product;

use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $id, $product, $category_id, $name, $slug, $brand, $short_description, $description, $regular_price, $sale_price, $quantity, $weight, $sale, $stock, $trending, $featured, $visibility, $meta_title, $meta_keyword, $meta_description, $image, $images, $product_id, $productImages, $productSize, $sizes, $product_size, $isChecked, $size_price;
    public $sizeTypes = [];
    public $sizeQuantity = [];
    public $sizePrice = [];

    public function mount($id)
    {
        $product = Product::where('id', $id)->first();

        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->brand = $product->brand;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->sale_price = $product->sale_price;
        $this->quantity = $product->quantity;
        $this->weight = $product->weight;
        $this->trending = $product->trending;
        $this->featured = $product->featured;
        $this->visibility = $product->visibility;
        $this->meta_title = $product->meta_title;
        $this->meta_keyword = $product->meta_keyword;
        $this->meta_description = $product->meta_description;

        foreach ($product->productSizes as $productSize) {
            $this->sizeTypes[$productSize->size_id] = true;
            $this->sizeQuantity[$productSize->size_id] = $productSize->quantity;
            $this->sizePrice[$productSize->size_id] = $productSize->size_price;
        }

        $this->productImages = ProductImage::where('product_id', $product->id)->get();
    }

    public function rules()
    {
        return [
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

    public function update()
    {
        $this->validate(); // Validate input fields

        $brand = $this->brand ?: 'No brand';
        $sale_price = $this->sale_price !== '' ? (int) $this->sale_price : 0;
        $quantity = $this->quantity !== '' ? (int) $this->quantity : 0;

        // $category = Category::findOrFail($this->category_id);

        $product = Product::findOrFail($this->product_id); // Find the product to update

        // Update product details
        $product->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
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
                // Save image
                $path = $image->store('public/uploads/images/products');

                // Create ProductImage entry
                $product->productImages()->create([
                    'image' => $path,
                ]);
            }
        }

        // Perbarui atau tambahkan ukuran dan harga
        if ($this->sizeTypes) {
            foreach ($this->sizeTypes as $sizeId => $isChecked) {
                // Jika kotak centang ukuran dicentang
                if ($isChecked) {
                    $productSize = ProductSize::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'size_id' => $sizeId
                        ],
                        [
                            'quantity' => $this->sizeQuantity[$sizeId] ?? 0,
                            'size_price' => $this->sizePrice[$sizeId] ?? 0
                        ]
                    );
                } else {
                    // Jika kotak centang ukuran tidak dicentang, hapus entri yang ada
                    ProductSize::where('product_id', $product->id)->where('size_id', $sizeId)->delete();
                }
            }
        }

        session()->flash('message', 'Product updated successfully.');

        return $this->redirect('/admin/products', navigate: true);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);

        if ($image) {
            // Delete associated file from storage
            Storage::delete($image->image);

            // Delete image entry from database
            $image->delete();

            session()->flash('message', 'Product image deleted successfully.');
            $this->productImages = ProductImage::where('product_id', $this->product_id)->get();
        } else {
            session()->flash('error', 'Failed to delete product image.');
        }
    }

    public function render()
    {
        $categories = Category::all();
        $sizesOption = Size::all();
        return view('livewire.admin.product.edit', compact('categories', 'sizesOption'))
            ->extends('livewire.layouts.admin')
            ->section('content');
    }
}
