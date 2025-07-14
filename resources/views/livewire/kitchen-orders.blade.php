<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Kitchen Orders</h1>

    <div wire:poll.keep-alive.5s>
        @foreach ($orders as $order)
            <div class="border rounded mb-4 p-4 shadow">
                <p class="font-semibold mb-1">Table: {{ $order->table->name }}</p>
                <p class="mb-2">Status: {{ ucfirst($order->status) }}</p>

                <ul class="mb-2">
                    @foreach ($order->orderItems as $item)
                        <li>🍽️ {{ $item->menuItem->name }} x {{ $item->quantity }}
                            @if ($item->note)
                                — <em>Note: {{ $item->note }}</em>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <button wire:click="markReady({{ $order->id }})"
                    class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Mark as Ready
                </button>
            </div>
        @endforeach

        @if ($orders->isEmpty())
            <p class="text-gray-600">No pending orders. 🎉</p>
        @endif
    </div>
</div>
