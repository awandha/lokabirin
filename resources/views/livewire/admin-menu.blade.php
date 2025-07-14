<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Menu Management</h1>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block mb-1">Name</label>
            <input type="text" wire:model="name" class="w-full border rounded p-2">
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Price</label>
            <input type="number" wire:model="price" class="w-full border rounded p-2">
            @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Image {{ $editId ? '(leave blank to keep old)' : '' }}</label>
            <input type="file" wire:model="image" class="w-full">
            @error('image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="is_available" class="mr-2">
                Available
            </label>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">
            {{ $editId ? 'Update Item' : 'Add Item' }}
        </button>
    </form>

    <table class="w-full border-collapse">
        <thead>
            <tr class="border-b">
                <th class="p-2 text-left">Image</th>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Price</th>
                <th class="p-2 text-left">Available</th>
                <th class="p-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr class="border-b">
                    <td class="p-2">
                        @if ($item->image_url)
                            <img src="{{ asset('storage/menu_images/' . $item->image_url) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="p-2">{{ $item->name }}</td>
                    <td class="p-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="p-2">{{ $item->is_available ? 'Yes' : 'No' }}</td>
                    <td class="p-2 space-x-2">
                        <button wire:click="edit({{ $item->id }})" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="px-2 py-1 bg-red-600 text-white rounded">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
