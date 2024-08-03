<?php

namespace App\Livewire\Front\Product;

use App\Models\Product;
use Livewire\WithPagination;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage;
    protected $queryString = ['search'];

    public $category;

    public function mount($category)
    {
        $this->category = $category;

        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function render()
    {
        $query = Product::query();

        $this->applySort($query);
        $this->applySearch($query);
        $this->applyCategoryFilter($query);

        $this->products = $query->paginate($this->perPage);

        return view('livewire.front.product.index', [
            'products' => $this->products,
            'category' => $this->category,
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
                $query->where('featured', '1');
                break;
            case 'trending':
                $query->where('trending', '1');
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
        $query->where('category_id', $this->category->id)->where('visibility', 0);
    }

    public function updateFilter()
    {
        $this->resetPage();
    }

}
