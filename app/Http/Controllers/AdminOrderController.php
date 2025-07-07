<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'orderItems.menuItem'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,in_progress,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }
}
