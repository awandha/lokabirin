<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MenuItem;

class AdminMenu extends Component
{
    use WithFileUploads;

    public $items;
    public $name, $price, $is_available = true, $image, $editId;

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = MenuItem::orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $path = $this->image ? $this->image->store('menu_images', 'public') : null;

        if ($this->editId) {
            $item = MenuItem::find($this->editId);
            $item->update([
                'name' => $this->name,
                'price' => $this->price,
                'is_available' => $this->is_available,
                'image_url' => $path ? basename($path) : $item->image_url,
            ]);
        } else {
            MenuItem::create([
                'name' => $this->name,
                'price' => $this->price,
                'is_available' => $this->is_available,
                'image_url' => basename($path),
            ]);
        }

        $this->reset(['name', 'price', 'image', 'is_available', 'editId']);
        $this->loadItems();
    }

    public function edit($id)
    {
        $item = MenuItem::find($id);
        $this->editId = $item->id;
        $this->name = $item->name;
        $this->price = $item->price;
        $this->is_available = $item->is_available;
    }

    public function delete($id)
    {
        MenuItem::find($id)->delete();
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.admin-menu');
    }
}
