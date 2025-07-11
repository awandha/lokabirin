<div class="space-y-6">

    {{-- ✅ Notifications --}}
    @if (session()->has('success'))
        <div class="p-4 bg-green-200 text-green-900 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-200 text-red-900 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Main container --}}
    <div class="py-6">
        <h1 class="text-2xl font-bold mb-4">Welcome to {{ $table->name }}</h1>

        {{-- ✅ Responsive grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($menuItems as $item)
                <div class="border rounded-lg overflow-hidden shadow hover:shadow-xl transition flex flex-col h-full bg-white">
                    {{-- ✅ Image --}}
                    @if ($item->image_url)
                        <img src="{{ asset('storage/menu_images/' . $item->image_url) }}"
                            alt="{{ $item->name }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    {{-- ✅ Card content --}}
                    <div class="flex flex-col flex-1 p-4">
                        <div class="flex-1">
                            <h2 class="text-lg font-bold mb-1 text-gray-800">{{ $item->name }}</h2>
                            <p class="text-sm text-gray-600 mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>

                        <button wire:click="addToCart({{ $item->id }})"
                                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full text-center">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ✅ Cart --}}
    <div class="mt-6">
        <h2 class="text-xl font-bold mb-2">Your Cart</h2>

        @if (empty($cart))
            <p>Your cart is empty.</p>
        @else
            <div class="space-y-4">
                @foreach ($cart as $itemId => $quantity)
                    @php $item = $menuItems->find($itemId); @endphp
                    <div class="border rounded-lg p-4 shadow flex flex-col space-y-2">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                            <button wire:click="removeFromCart({{ $itemId }})"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Remove
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Quantity</label>
                            <input type="number"
                                wire:change="updateQuantity({{ $itemId }}, $event.target.value)"
                                value="{{ $quantity }}"
                                min="1"
                                class="border rounded px-2 py-1 w-full">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Note</label>
                            <input type="text"
                                wire:model="notes.{{ $itemId }}"
                                placeholder="Optional note"
                                class="border rounded px-2 py-1 w-full">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button wire:click="placeOrder"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full sm:w-auto">
                    Place Order
                </button>
            </div>
        @endif
    </div>

</div>
