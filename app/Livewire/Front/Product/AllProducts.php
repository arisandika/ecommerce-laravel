<?php

namespace App\Livewire\Front\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AllProducts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage, $categoryFilter = [];
    protected $queryString = ['search', 'categoryFilter'];

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 12;
    }

    public function render()
    {
        $query = Product::query();

        $this->applySort($query);
        $this->applySearch($query);
        $this->applyCategoryFilter($query);

        $categories = Category::where('visibility', '0')
            ->where('slug', '<>', 'categories')
            ->get();

        $products = $query->where('visibility', 0)
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.front.product.all-products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    private function applySort($query)
    {
        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'onsale':
                $query->where('sale_price', '>', 0);
                break;
            case 'featured':
                $query->where('featured', 1);
                break;
            case 'trending':
                $query->where('trending', 1);
                break;
            case 'price_low_to_high':
                $query->orderByRaw('IF(sale_price > 0, sale_price, regular_price)');
                break;
            case 'price_high_to_low':
                $query->orderByRaw('IF(sale_price > 0, sale_price, regular_price) DESC');
                break;
        }
    }

    private function applySearch($query)
    {
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
    }

    private function applyCategoryFilter($query)
    {
        if ($this->categoryFilter) {
            $query->whereIn('category_id', $this->categoryFilter);
        }
    }

    public function updateFilter()
    {
        $this->resetPage();
    }

}
