<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
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
    public $name, $slug, $visibility, $newImage, $categoryId, $editCategory, $oldImage;

    public function mount()
    {
        $this->sortBy = "default";
        $this->perPage = 10;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'visibility' => 'nullable',
            'newImage' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function store()
    {
        $this->validate();

        if ($this->newImage) {
            $imagePath = $this->newImage->store('public/uploads/images/category');
        } else {
            $imagePath = null;
        }

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'image' => $imagePath,
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Category added successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/categories', navigate: true);
    }

    public function getDataEdit($id)
    {
        $category = Category::findOrFail($id);

        $this->categoryId = $category->id;

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->visibility = $category->visibility;

        $this->oldImage = $category->image;
    }

    public function update()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);

        if ($this->newImage) {
            $imagePath = $this->newImage->store('public/uploads/images/category');

            // Hapus gambar lama jika ada
            if ($category->image && Storage::exists($category->image)) {
                Storage::delete($category->image);
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang ada
            $imagePath = $category->image;
        }

        $category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'image' => $imagePath,
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Category updated successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/categories', navigate: true);
    }

    public function getDataDelete($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function delete()
    {
        $category = Category::findOrFail($this->categoryId);

        if (!empty($category->image) && Storage::exists($category->image)) {
            Storage::delete($category->image);
        }

        $category->delete();

        $this->reset();

        session()->flash('message', 'Category deleted successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/categories', navigate: true);
    }

    public function deleteSelected()
    {
        // Pastikan ada item yang dipilih
        if (count($this->checkedItems) > 0) {
            foreach ($this->checkedItems as $itemId) {
                $category = Category::findOrFail($itemId);

                // Hapus gambar jika ada
                if (!empty($category->image) && Storage::exists($category->image)) {
                    Storage::delete($category->image);
                }

                // Hapus kategori dari database
                $category->delete();
            }

            // Clear the checkedItems array setelah penghapusan
            $this->checkedItems = [];

            // Tutup modal setelah penghapusan
            $this->closeModal();

            session()->flash('message', 'Categories deleted successfully.');

            $this->dispatch('close-modal');

            return $this->redirect('/admin/categories', navigate: true);
        }
    }

    public function render()
    {
        $query = Category::query();

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

        // Fetch categories with applied sorting and search
        $categories = $query->orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.admin.category.index', [
            'categories' => $categories,
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
