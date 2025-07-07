<div class="space-y-6">
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

    <h1 class="text-2xl font-bold">Welcome to {{ $table->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($menuItems as $item)
            <div class="border rounded p-4 shadow">
                <h2 class="text-lg font-semibold">{{ $item->name }}</h2>
                <p class="text-gray-600 mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <button wire:click="addToCart({{ $item->id }})"
                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Add to Cart
                </button>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-bold mb-2">Your Cart</h2>

        @if (empty($cart))
            <p>Your cart is empty.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Item</th>
                        <th class="py-2">Qty</th>
                        <th class="py-2">Note</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $itemId => $quantity)
                        @php $item = $menuItems->find($itemId); @endphp
                        <tr class="border-b">
                            <td class="py-2">{{ $item->name }}</td>
                            <td class="py-2">
                                <input type="number"
                                       wire:change="updateQuantity({{ $itemId }}, $event.target.value)"
                                       value="{{ $quantity }}"
                                       min="1"
                                       class="border rounded px-2 py-1 w-20">
                            </td>
                            <td class="py-2">
                                <input type="text"
                                       wire:model="notes.{{ $itemId }}"
                                       placeholder="Optional note"
                                       class="border rounded px-2 py-1 w-full">
                            </td>
                            <td class="py-2">
                                <button wire:click="removeFromCart({{ $itemId }})"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button wire:click="placeOrder"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Place Order
                </button>
            </div>
        @endif
    </div>
</div>
