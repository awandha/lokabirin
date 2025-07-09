<div wire:poll.keep-alive.5s>
    <div>
        <p>Time: {{ now() }}</p>
        <button onclick="enableSound()" class="px-4 py-2 bg-blue-600 text-white rounded">
            🔔 Enable Order Notification Sound
        </button>
    </div>

    @foreach ($orders as $order)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;"
            class="{{ $order->id === $flashOrderId ? 'flash' : '' }}">
            <p>Table: {{ $order->table->name }}</p>
            <p>Status: {{ $order->status }}</p>
            <p>Total: Rp {{ $order->total_price }}</p>
            <ul>
                @foreach ($order->orderItems as $item)
                    <li>{{ $item->menuItem->name }} x {{ $item->quantity }}</li>
                @endforeach
            </ul>

            <form wire:submit.prevent="updateStatus({{ $order->id }}, $event.target.status.value)">
                <select name="status">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </div>
    @endforeach

    <audio id="newOrderSound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

    <style>
        .flash {
            animation: flash 1s ease;
        }
        @keyframes flash {
            0% { background: yellow; }
            100% { background: transparent; }
        }
    </style>

    <script>
        window.addEventListener('new-order-received', () => {
            console.log('🔔 New order received!');
            const sound = document.getElementById('newOrderSound');
            if (sound) {
                sound.play();
            }
        });
    </script>
    <script>
    function enableSound() {
        const sound = document.getElementById('newOrderSound');
        sound.play().then(() => {
            console.log('Sound enabled!');
        }).catch(e => {
            console.warn('Failed to play immediately:', e);
        });
    }
    </script>
</div>
