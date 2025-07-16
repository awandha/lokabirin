<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">📊 Sales Report</h1>

    {{-- Filter Form --}}
    <form wire:submit.prevent="$refresh" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
        <div>
            <label class="block mb-1 font-semibold">📅 From Date</label>
            <input type="date" wire:model="fromDate" name="fromDate" class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label class="block mb-1 font-semibold">📅 To Date</label>
            <input type="date" wire:model="toDate" name="toDate" class="border rounded px-3 py-2 w-full">
        </div>
        <div class="flex gap-2">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                🔍 Filter
            </button>
            <a href="{{ route('admin.reports.export', ['fromDate' => $fromDate, 'toDate' => $toDate]) }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                ⬇️ Export CSV
            </a>
        </div>
    </form>

    {{-- Summary --}}
    <div class="mb-6">
        <p class="mb-1">🧾 <strong>Total Orders:</strong> {{ $totalOrders }}</p>
        <p class="mb-1">💰 <strong>Total Revenue:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="mb-1">📌 <strong>Status Breakdown:</strong></p>
        <ul class="ml-4 list-disc">
            @forelse ($statusCounts as $status => $count)
                <li>{{ ucfirst($status) }}: {{ $count }}</li>
            @empty
                <li>No orders found.</li>
            @endforelse
        </ul>
    </div>

    {{-- Orders Table --}}
    <div class="overflow-x-auto border rounded">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">📌 Table</th>
                    <th class="px-4 py-2 border">📦 Status</th>
                    <th class="px-4 py-2 border">💸 Total</th>
                    <th class="px-4 py-2 border">⏰ Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $order->table->name }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No orders found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
