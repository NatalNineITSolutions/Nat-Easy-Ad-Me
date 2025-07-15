<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

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

    public function updateProductStatus(Request $request, OrderDetail $order, $index)
    {
        $request->validate([
            'order_status' => 'required|in:pending,packaging,shipped,delivered'
        ]);

        $statuses = explode('|', $order->order_status);
        $statuses[$index] = $request->order_status;
        $order->order_status = implode('|', $statuses);
        $order->save();

        return back()->with('success', 'Product status updated successfully.');
    }


    public function viewOrderDetails(OrderDetail $order)
    {
        $order->load(['country', 'state', 'city', 'user.sponsor']); // 👈 add user.sponsor

        $productIds = explode('|', $order->product_id);
        $quantities = explode('|', $order->product_quantity);
        $prices     = explode('|', $order->product_total_price);
        $sizes      = explode('|', $order->size);

        $products = collect($productIds)->map(function ($id) {
            return Product::find($id);
        });

        return view('backend.pages.orders.order-view-details', [
            'order'      => $order,
            'products'   => $products,
            'quantities' => $quantities,
            'prices'     => $prices,
            'sizes'      => $sizes,
        ]);
    }

    public function downloadInvoice($id)
    {
        $order = OrderDetail::with(['country', 'state', 'city'])->findOrFail($id);

        $productIds = explode('|', $order->product_id);
        $quantities = explode('|', $order->product_quantity);
        $prices     = explode('|', $order->product_total_price);
        $sizes      = explode('|', $order->size);

        $products = collect($productIds)->map(fn($id) => Product::find($id));

        $productTotal = array_sum(array_map('floatval', $prices));
        $deliveryTotal = floatval($order->total_delivery_charge);
        $grandTotal = floatval($order->grand_total);

        $site_logo_id = get_static_option('site_logo');
        $site_logo = get_attachment_image_by_id($site_logo_id, null, true); // returns ['img_url' => ..., ...]
        $site_logo_url = $site_logo['img_url'] ?? null;

        $pdf = Pdf::loadView('backend.pages.orders.invoice', compact(
            'order',
            'products',
            'quantities',
            'prices',
            'sizes',
            'productTotal',
            'deliveryTotal',
            'grandTotal',
            'site_logo_url'
        ));

        return $pdf->download('invoice-order-' . $order->id . '.pdf');
    }

    public function downloadProductInvoice(OrderDetail $order, $index)
    {
        // Load related data including sponsor
        $order->load(['country', 'state', 'city', 'user.sponsor']);

        $productIds = explode('|', $order->product_id);
        $quantities = explode('|', $order->product_quantity);
        $prices     = explode('|', $order->product_total_price);
        $sizes      = explode('|', $order->size);
        $statuses   = explode('|', $order->order_status);

        $product  = Product::find($productIds[$index] ?? null);
        $quantity = $quantities[$index] ?? 0;
        $price    = $prices[$index] ?? 0;
        $size     = $sizes[$index] ?? '-';
        $status   = $statuses[$index] ?? 'pending';

        $site_logo_id  = get_static_option('site_logo');
        $site_logo     = get_attachment_image_by_id($site_logo_id, null, true);
        $site_logo_url = $site_logo['img_url'] ?? null;

        $pdf = Pdf::loadView('backend.pages.orders.invoice-single-product', compact(
            'order',
            'product',
            'quantity',
            'price',
            'size',
            'status',
            'site_logo_url'
        ));

        return $pdf->download('invoice-order-' . $order->id . '-product-' . ($index + 1) . '.pdf');
    }

}
