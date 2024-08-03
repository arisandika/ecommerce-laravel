<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
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
    public $name, $slug, $description, $visibility, $newImage, $sliderId, $editSlider, $oldImage;

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
            'description' => 'nullable|string',
            'visibility' => 'nullable',
            'newImage' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function store()
    {
        $this->validate();

        if ($this->newImage) {
            $imagePath = $this->newImage->store('public/uploads/images/slider');
        } else {
            $imagePath = null;
        }

        Slider::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $imagePath,
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Slider added successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sliders', navigate: true);
    }

    public function getDataEdit($id)
    {
        $slider = Slider::findOrFail($id);

        $this->sliderId = $slider->id;

        $this->name = $slider->name;
        $this->slug = $slider->slug;
        $this->description = $slider->description;
        $this->visibility = $slider->visibility;

        $this->oldImage = $slider->image;
    }

    public function update()
    {
        $this->validate();

        $slider = Slider::findOrFail($this->sliderId);

        if ($this->newImage) {
            $imagePath = $this->newImage->store('public/uploads/images/slider');

            // Hapus gambar lama jika ada
            if ($slider->image && Storage::exists($slider->image)) {
                Storage::delete($slider->image);
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang ada
            $imagePath = $slider->image;
        }

        $slider->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $imagePath,
            'visibility' => $this->visibility == true ? '1' : '0',
        ]);

        $this->reset();

        session()->flash('message', 'Slider updated successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sliders', navigate: true);
    }

    public function getDataDelete($sliderId)
    {
        $this->sliderId = $sliderId;
    }

    public function delete()
    {
        $slider = Slider::findOrFail($this->sliderId);

        if (!empty($slider->image) && Storage::exists($slider->image)) {
            Storage::delete($slider->image);
        }

        $slider->delete();

        $this->reset();

        session()->flash('message', 'Slider deleted successfully.');

        $this->dispatch('close-modal');

        return $this->redirect('/admin/sliders', navigate: true);
    }

    public function deleteSelected()
    {
        // Pastikan ada item yang dipilih
        if (count($this->checkedItems) > 0) {
            foreach ($this->checkedItems as $itemId) {
                $slider = Slider::findOrFail($itemId);

                // Hapus gambar jika ada
                if (!empty($slider->image) && Storage::exists($slider->image)) {
                    Storage::delete($slider->image);
                }

                // Hapus kategori dari database
                $slider->delete();
            }

            // Clear the checkedItems array setelah penghapusan
            $this->checkedItems = [];

            // Tutup modal setelah penghapusan
            $this->closeModal();

            session()->flash('message', 'Categories deleted successfully.');

            $this->dispatch('close-modal');

            return $this->redirect('/admin/sliders', navigate: true);
        }
    }

    public function render()
    {
        $query = Slider::query();

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

        // Fetch sliders with applied sorting and search
        $sliders = $query->orderByDesc('created_at')->paginate($this->perPage);

        return view('livewire.admin.slider.index', [
            'sliders' => $sliders,
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
