<div class="max-w-xl mx-auto space-y-6">
    @if (session()->has('success'))
        <div class="p-4 bg-green-200 text-green-900 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold">Add New Menu Item</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" wire:model="name" class="border rounded w-full px-3 py-2">
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1">Price</label>
            <input type="number" wire:model="price" class="border rounded w-full px-3 py-2">
            @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1">Image</label>
            <input type="file" wire:model="image" class="border rounded w-full px-3 py-2">
            @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" wire:model="is_available" class="mr-2">
            <label>Available</label>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Save
        </button>
    </form>

    <h3 class="text-xl font-bold mt-8">Current Menu Items</h3>
    <div class="space-y-2">
        @foreach ($menuItems as $item)
            <div class="border p-4 rounded flex justify-between items-center">
                <div>
                    <strong>{{ $item->name }}</strong> - Rp {{ number_format($item->price, 0, ',', '.') }}
                    @if ($item->image_url)
                        <img src="{{ asset('storage/menu_images/' . $item->image_url) }}" alt="" class="h-16 mt-2">
                    @endif
                </div>
                <span class="text-sm text-gray-600">
                    {{ $item->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>
        @endforeach
    </div>
</div>
