<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage;
    protected $queryString = ['search'];
    public $order_id, $tracking_no, $fullname, $email, $phone, $postcode, $address, $subtotal_price, $shipping_cost, $total_price, $status_order, $payment_method, $snap_token, $payment_id, $orderId;

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function render()
    {
        $todayDate = Carbon::now();

        $query = Order::query();

        // Apply sorting filters
        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'paid':
                $query->whereNot('status_order', ['Pending', 'Cancelled']);
                break;
            case 'unpaid':
                $query->where('status_order', 'Pending');
                break;
            case 'packaged':
                $query->where('status_order', 'Being Packaged');
                break;
            case 'toship':
                $query->where('status_order', 'To Ship');
                break;
            case 'receive':
                $query->where('status_order', 'To Receive');
                break;
            case 'completed':
                $query->where('status_order', 'To Completed');
                break;
        }

        // Apply search filter
        if ($this->search) {
            $query->where('fullname', 'like', '%' . $this->search . '%');
        }

        // Fetch sliders with applied sorting and search
        $orders = $query->orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.admin.order.index', [
            'orders' => $orders,
        ])->extends('livewire.layouts.admin')->section('content');
    }

    public function updateFilter()
    {
        $this->resetPage();
    }

    public function showDetail($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('livewire.admin.order.detail', [
            'order' => $order,
        ]);
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

        return $this->redirect('/admin/orders', navigate: true);
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
