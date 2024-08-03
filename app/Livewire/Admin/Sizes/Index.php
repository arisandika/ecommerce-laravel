<?php

namespace App\Livewire\Admin\Sizes;

use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search, $sortBy, $perPage;
    protected $queryString = ['search'];
    public $checkedItems = [];
    public $name, $code, $visibility, $sizesId, $editSizes;

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'nullable|string',
            'visibility' => 'nullable',
        ];
    }

    public function store()
    {
        $this->validate();

        Size::create([
            'name' => $this->name,
            'code' => Str::slug($this->code),
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Sizes added successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sizes', navigate: true);
    }

    public function getDataEdit($id)
    {
        $size = Size::findOrFail($id);

        $this->sizesId = $size->id;

        $this->name = $size->name;
        $this->code = $size->code;
        $this->visibility = $size->visibility;
    }

    public function update()
    {
        $this->validate();

        $size = Size::findOrFail($this->sizesId);

        $size->update([
            'name' => $this->name,
            'code' => Str::slug($this->code),
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Sizes updated successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sizes', navigate: true);
    }

    public function getDataDelete($sizeId)
    {
        $this->sizesId = $sizeId;
    }

    public function delete()
    {
        $size = Size::findOrFail($this->sizesId);

        $size->delete();

        $this->reset();

        session()->flash('message', 'Sizes deleted successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sizes', navigate: true);
    }

    public function deleteSelected()
    {
        // Pastikan ada item yang dipilih
        if (count($this->checkedItems) > 0) {
            foreach ($this->checkedItems as $itemId) {
                $size = Size::findOrFail($itemId);

                // Hapus kategori dari database
                $size->delete();
            }

            // Clear the checkedItems array setelah penghapusan
            $this->checkedItems = [];

            // Tutup modal setelah penghapusan
            $this->closeModal();

            session()->flash('message', 'Categories deleted successfully.');

            $this->dispatch('close-modal');

            return $this->redirect('/admin/sizes', navigate: true);
        }
    }

    public function render()
    {
        $query = Size::query();

        // Apply sorting filters
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
        }

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Fetch sizes with applied sorting and search
        $sizes = $query->orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.admin.sizes.index', [
            'sizes' => $sizes,
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
