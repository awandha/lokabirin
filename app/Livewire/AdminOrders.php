<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class AdminOrders extends Component
{
    public $orders;
    public $flashOrderId = null;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $latestOrder = Order::latest()->first();
        $this->flashOrderId = $latestOrder->id;

        $this->orders = Order::with(['table', 'orderItems.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Trigger a browser event
        $this->dispatch('new-order-received');
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
            'orders' => $this->orders,
        ]);
    }

    protected function getListeners()
    {
        return [
            'echo:orders,OrderPlaced' => 'loadOrders',
        ];
    }
}
