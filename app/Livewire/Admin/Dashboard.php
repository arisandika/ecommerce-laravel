<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage;
    public $orderId, $status_order;
    public $totalPrice = 0;

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function render()
    {
        $products = Product::all();

        $orders = Order::orderByDesc('created_at')->get();

        $orderSuccess = Order::whereNotIn('status_order', ['Pending', 'Cancelled'])->get();
        $totalPrice = $orderSuccess->sum('total_price');

        return view('livewire.admin.dashboard', [
            'orders' => $orders,
            'orderSuccess' => $orderSuccess,
            'products' => $products,
        ])->extends('livewire.layouts.admin')->section('content');
    }

    public function getDataEdit($orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->orderId = $order->id;

        $this->status_order = $order->status_order;
    }

    public function update()
    {
        $order = order::findOrFail($this->orderId);

        $order->update([
            'status_order' => $this->status_order,
        ]);

        session()->flash('message', 'Status order updated successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/dashboard', navigate: true);
    }

    public function closeModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->reset();
    }
}
