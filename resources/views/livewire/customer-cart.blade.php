<div class="max-w-5xl mx-auto p-4 space-y-6">

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Banner with overlay --}}
    <div class="relative w-full overflow-hidden rounded-lg mb-4 h-48 md:h-64">
        <img
            src="{{ asset('storage/images/customer-banner.png') }}"
            alt="Welcome Banner"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        {{-- Text on banner --}}
        <div class="relative z-10 flex items-center justify-center h-full">
            <h1 class="text-white text-2xl md:text-4xl font-bold text-center px-4">
                Welcome to {{ $table->name }}
            </h1>
        </div>
    </div>

    {{-- ✅ Sticky Categories --}}
    <div class="sticky top-0 bg-white z-10 border-b">
        <div class="flex overflow-x-auto gap-2 py-2 px-1 scrollbar-hide">
            <button
                wire:click="setCategory('all')"
                class="flex-shrink-0 px-3 py-1 rounded border whitespace-nowrap
                    {{ $activeCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                All
            </button>

            @foreach ($categories as $category)
                <button
                    wire:click="setCategory({{ $category->id }})"
                    class="flex-shrink-0 px-3 py-1 rounded border whitespace-nowrap
                        {{ $activeCategory === $category->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ✅ Search --}}
    <div class="mb-4">
        <form wire:submit.prevent="searchMenu" class="flex gap-2">
            <input
                type="text"
                wire:model.defer="search"
                placeholder="Search menu..."
                class="flex-1 border rounded px-4 py-2"
            >
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Search
            </button>
        </form>
    </div>

    {{-- ✅ Menu Items --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse ($menuItems as $item)
            <div class="border rounded overflow-hidden shadow hover:shadow-lg transition flex flex-col">
                @if ($item->image_url)
                    <img
                        src="{{ asset('storage/menu_images/' . $item->image_url) }}"
                        alt="{{ $item->name }}"
                        class="w-full h-40 object-cover"
                    >
                @else
                    <div class="w-full h-40 flex items-center justify-center bg-gray-100 text-gray-500">
                        No Image
                    </div>
                @endif

                <div class="p-4 flex flex-col flex-grow">
                    <h2 class="text-lg font-bold mb-1">{{ $item->name }}</h2>
                    <p class="text-gray-600 mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    <button
                        wire:click="addToCart({{ $item->id }})"
                        class="mt-auto px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-center w-full">
                        Add to Cart
                    </button>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">No menu items found.</p>
        @endforelse
    </div>

    {{-- ✅ Cart --}}
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-2">Your Cart</h2>

        @if (empty($cart))
            <p class="text-gray-500">Your cart is empty.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border">Item</th>
                            <th class="px-3 py-2 border">Qty</th>
                            <th class="px-3 py-2 border">Note</th>
                            <th class="px-3 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $itemId => $quantity)
                            @php $item = $allItems->find($itemId); @endphp
                            <tr>
                                <td class="border px-3 py-2">{{ $item->name }}</td>
                                <td class="border px-3 py-2">
                                    <input
                                        type="number"
                                        wire:change="updateQuantity({{ $itemId }}, $event.target.value)"
                                        value="{{ $quantity }}"
                                        min="1"
                                        class="border rounded px-2 py-1 w-20"
                                    >
                                </td>
                                <td class="border px-3 py-2">
                                    <input
                                        type="text"
                                        wire:model="notes.{{ $itemId }}"
                                        placeholder="Optional note"
                                        class="border rounded px-2 py-1 w-full"
                                    >
                                </td>
                                <td class="border px-3 py-2">
                                    <button
                                        wire:click="removeFromCart({{ $itemId }})"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button
                    wire:click="placeOrder"
                    class="px-5 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Place Order
                </button>
            </div>
        @endif
    </div>
</div>
