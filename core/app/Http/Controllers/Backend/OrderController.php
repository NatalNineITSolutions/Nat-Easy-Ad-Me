<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function allOrders()
    {
        $orders = OrderDetail::with(['user', 'product', 'country', 'state', 'city'])->latest()->paginate(10);
        return view('backend.pages.orders.all-orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,packaging,shipped,delivered'
        ]);

        $order = OrderDetail::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

}
