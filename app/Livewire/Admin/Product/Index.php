<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage;
    protected $queryString = ['search'];
    public $checkedItems = [];
    public $id, $product, $category_id, $name, $slug, $brand, $short_description, $description, $regular_price, $sale_price, $quantity, $weight, $sale, $stock, $trending, $featured, $visibility, $meta_title, $meta_keyword, $meta_description, $image, $images, $product_id, $productImages, $productId;
    public $sizeTypes = [];
    public $sizeQuantity = [];
    public $sizePrice = [];

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function getDetail($id)
    {
        $product = Product::findOrFail($id);

        $this->product_id = $product->id;
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

    public function getDataDelete($productId)
    {
        $this->productId = $productId;
    }

    public function delete()
    {
        $product = Product::findOrFail($this->productId);

        // Check if the product has associated images
        if ($product->productImages->isNotEmpty()) {
            // Delete associated product images
            $product->productImages()->delete();

            // Delete storage files
            foreach ($product->productImages as $image) {
                Storage::delete($image->image);
            }
        }

        // Delete the product
        $product->delete();

        session()->flash('message', 'Product deleted successfully.');

        return $this->redirect('/admin/products', navigate: true);
    }

    public function deleteSelected()
    {
        // Pastikan ada item yang dipilih
        if (count($this->checkedItems) > 0) {
            foreach ($this->checkedItems as $itemId) {
                $product = Product::findOrFail($itemId);

                // Hapus gambar jika ada
                if ($product->productImages->isNotEmpty()) {
                    // Delete associated product images
                    $product->productImages()->delete();

                    // Delete storage files
                    foreach ($product->productImages as $image) {
                        Storage::delete($image->image);
                    }
                }

                // Hapus kategori dari database
                $product->delete();
            }

            // Clear the checkedItems array setelah penghapusan
            $this->checkedItems = [];

            // Tutup modal setelah penghapusan
            $this->closeModal();

            session()->flash('message', 'Products deleted successfully.');

            $this->dispatch('close-modal');

            return $this->redirect('/admin/products', navigate: true);
        }
    }

    public function render()
    {
        $query = Product::query();

        // Apply sort filters
        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'publish':
                $query->where('visibility', '0');
                break;
            case 'private':
                $query->where('visibility', '1');
                break;
            case 'instock':
                $query->where('quantity', '>', 0);
                break;
            case 'outstock':
                $query->where('quantity', '<', 1);
                break;
            case 'onsale':
                $query->where('sale_price', '>', 0);
                break;
            case 'featured':
                $query->where('featured', '1');
                break;
            case 'trending':
                $query->where('trending', '1');
                break;
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        // Fetch products with applied sorting and search
        $products = $query->orderByDesc('created_at')->paginate($this->perPage);
        $sizesOption = Size::all();

        return view('livewire.admin.product.index', [
            'products' => $products,
            'sizesOption' => $sizesOption,
        ])->extends('livewire.layouts.admin')->section('content');
    }

    public function updateFilter()
    {
        $this->resetPage();
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['checkedItems']);
    }

    public function openModal()
    {
        $this->reset();
    }
}
