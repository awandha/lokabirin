<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Events\OrderPlaced;

class CustomerCart extends Component
{
    public $table;
    public $cart = [];
    public $notes = [];
    public $categories;
    public $activeCategory = 'all';
    public $search = '';

    public function searchMenu()
    {
        // No logic — the render() will handle it automatically
    }

    public function mount($tableCode)
    {
        $this->table = Table::where('table_code', $tableCode)->firstOrFail();
        $this->categories = Category::all();
    }

    public function setCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
    }

    public function addToCart($menuItemId)
    {
        $this->cart[$menuItemId] = ($this->cart[$menuItemId] ?? 0) + 1;
    }

    public function removeFromCart($menuItemId)
    {
        unset($this->cart[$menuItemId]);
    }

    public function updateQuantity($menuItemId, $quantity)
    {
        $quantity <= 0
            ? $this->removeFromCart($menuItemId)
            : $this->cart[$menuItemId] = $quantity;
    }

    public function placeOrder()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        $order = Order::create([
            'table_id' => $this->table->id,
            'status' => 'pending',
        ]);

        $total = 0;
        foreach ($this->cart as $itemId => $quantity) {
            $menuItem = MenuItem::findOrFail($itemId);
            $total += $menuItem->price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'quantity' => $quantity,
                'note' => $this->notes[$itemId] ?? null,
            ]);
        }

        $order->update(['total_price' => $total]);

        $this->cart = [];
        $this->notes = [];
        event(new OrderPlaced($order));
        session()->flash('success', 'Order placed! Thank you.');
    }

    public function render()
    {
        $query = MenuItem::query()->where('is_available', true);

        if ($this->activeCategory !== 'all') {
            $query->where('category_id', $this->activeCategory);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.customer-cart', [
            'menuItems' => $query->get(),
            'allItems' => MenuItem::where('is_available', true)->get(),
        ]);
    }
}
