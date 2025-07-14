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
    public $menuItems;
    public $cart = [];
    public $notes = [];
    public $categories;
    public $activeCategory;

    public function loadMenuItems()
    {
        $query = MenuItem::where('is_available', true);

        if ($this->activeCategory && $this->activeCategory !== 'all') {
            $query->where('category_id', $this->activeCategory);
        }

        $this->menuItems = $query->get();
    }

    public function mount($tableCode)
    {
        $this->table = Table::where('table_code', $tableCode)->firstOrFail();
        $this->categories = Category::all();
        $this->activeCategory = 'all';

        $this->loadMenuItems();
    }

    public function setCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
        $this->loadMenuItems();
    }


    public function addToCart($menuItemId)
    {
        if (isset($this->cart[$menuItemId])) {
            $this->cart[$menuItemId]++;
        } else {
            $this->cart[$menuItemId] = 1;
        }
    }

    public function removeFromCart($menuItemId)
    {
        if (isset($this->cart[$menuItemId])) {
            unset($this->cart[$menuItemId]);
        }
    }

    public function updateQuantity($menuItemId, $quantity)
    {
        if ($quantity <= 0) {
            unset($this->cart[$menuItemId]);
        } else {
            $this->cart[$menuItemId] = $quantity;
        }
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

        session()->flash('success', 'Order placed! Thank you.');
        event(new OrderPlaced($order));
    }

    public function render()
    {
        return view('livewire.customer-cart');
    }
}
