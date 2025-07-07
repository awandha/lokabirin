<div wire:poll.keep-alive.5s>
    <div>
        <p>Time: {{ now() }}</p>
    </div>

    @foreach ($orders as $order)
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
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
</div>
