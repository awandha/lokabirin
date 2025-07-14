<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class KitchenOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::with(['table', 'orderItems.menuItem'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('created_at')
            ->get();
    }

    public function markReady($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'completed']);
        $this->loadOrders();
    }

    protected function getListeners()
    {
        return [
            'echo:orders,OrderPlaced' => 'loadOrders',
        ];
    }

    public function render()
    {
        $this->loadOrders();
        return view('livewire.kitchen-orders');
    }
}
