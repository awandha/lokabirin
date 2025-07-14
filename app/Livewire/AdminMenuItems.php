<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MenuItem;

class AdminMenuItems extends Component
{
    use WithFileUploads;

    public $name, $price, $is_available = true, $image, $menuItems;

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->menuItems = MenuItem::orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($this->image) {
            $path = $this->image->store('menu_images', 'public');
            \Log::info('Image stored at inside: ' . $path);
        }
        \Log::info('Image stored at basename: ' . basename($path));

        MenuItem::create([
            'name' => $this->name,
            'price' => $this->price,
            'is_available' => $this->is_available,
            'image_url' => $path ? basename($path) : null,
        ]);

        $this->reset(['name', 'price', 'is_available', 'image']);
        $this->loadItems();

        session()->flash('success', 'Menu item added!');
    }

    public function render()
    {
        return view('livewire.admin-menu-items');
    }
}
