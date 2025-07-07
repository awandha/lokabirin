<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function showMenu($table_code)
    {
        $table = Table::where('table_code', $table_code)->firstOrFail();
        $menuItems = MenuItem::where('is_available', true)->get();
        return view('customer.menu', compact('table', 'menuItems'));
    }

    public function placeOrder(Request $request, $table_code)
    {
        $table = Table::where('table_code', $table_code)->firstOrFail();

        $items = collect($request->items)
            ->filter(fn($qty) => $qty > 0);

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Please add at least one item.');
        }

        $order = Order::create([
            'table_id' => $table->id,
            'status' => 'pending',
        ]);

        $total = 0;

        foreach ($items as $item_id => $quantity) {
            $menuItem = MenuItem::findOrFail($item_id);
            $total += $menuItem->price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'quantity' => $quantity,
                'note' => $request->notes[$item_id] ?? null,
            ]);
        }

        $order->update(['total_price' => $total]);

        return redirect()->back()->with('success', 'Order placed! Thank you.');
    }
}
