<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class AdminOrders extends Component
{
    use WithPagination;

    public $flashOrderId = null;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $latestOrder = Order::latest()->first();
        $this->flashOrderId = $latestOrder->id;
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.admin-orders', [
            'orders' => Order::with(['table', 'orderItems.menuItem'])
                ->orderBy('created_at', 'desc')
                ->paginate(10), // 10 orders per page
        ]);
    }

    protected function getListeners()
    {
        return [
            'echo:orders,OrderPlaced' => 'loadOrders',
        ];
    }
}
