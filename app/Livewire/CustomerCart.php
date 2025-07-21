<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Events\OrderPlaced;

class CustomerCart extends Component
{
    use WithPagination;

    public $table;
    public $cart = [];
    public $notes = [];

    public $categories;
    public $activeCategory = 'all';
    public $search = '';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'activeCategory' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    public function mount($tableCode)
    {
        $this->table = Table::where('table_code', $tableCode)->firstOrFail();
        $this->categories = Category::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setCategory($categoryId)
    {
        $this->activeCategory = $categoryId;
        $this->resetPage(); // ✅ Fix: reset page when changing category!
    }

    public function addToCart($menuItemId)
    {
        $this->cart[$menuItemId] = ($this->cart[$menuItemId] ?? 0) + 1;

        $item = \App\Models\MenuItem::find($menuItemId);
        $this->dispatch('cart-updated', [
            'message' => "{$item->name} added to cart!"
        ]);
    }

    public function removeFromCart($menuItemId)
    {
        unset($this->cart[$menuItemId]);
    }

    public function updateQuantity($menuItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($menuItemId);
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
        event(new OrderPlaced($order));

        // ✅ Redirect to thank you page
        return redirect()->route('customer.thank-you', ['table_code' => $this->table->table_code]);
    }

    public function render()
    {
        $query = MenuItem::where('is_available', true);

        if ($this->activeCategory !== 'all') {
            $query->where('category_id', $this->activeCategory);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $menuItems = $query->paginate(9);

        return view('livewire.customer-cart', [
            'menuItems' => $menuItems,
            'allItems' => MenuItem::all(),
        ]);
    }
}
