<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Kitchen Orders</h1>

    <div wire:poll.keep-alive.5s>
        @foreach ($orders as $order)
            <div class="border rounded mb-4 p-4 shadow">
                <p class="font-semibold mb-1">
                    Table: {{ $order->table->name }}
                </p>
                <p class="mb-2">
                    Status:
                    <span class="@if($order->status == 'pending') bg-yellow-200 text-yellow-800 @elseif($order->status == 'in_progress') bg-blue-200 text-blue-800 @else bg-green-200 text-green-800 @endif px-2 py-1 rounded">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                <ul class="mb-2">
                    @foreach ($order->orderItems as $item)
                        <li>🍽️ {{ $item->menuItem->name }} x {{ $item->quantity }}
                            @if ($item->note)
                                — <em>Note: {{ $item->note }}</em>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if ($order->status === 'pending')
                    <button wire:click="markInProgress({{ $order->id }})"
                        class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Mark In Progress
                    </button>
                @elseif ($order->status === 'in_progress')
                    <button wire:click="markReady({{ $order->id }})"
                        class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Mark as Ready
                    </button>
                @endif
            </div>
        @endforeach

        @if ($orders->isEmpty())
            <p class="text-gray-600">No pending orders. 🎉</p>
        @endif
    </div>
</div>
