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

    public function updateProductStatus(Request $request, OrderDetail $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,packaging,shipped,delivered',
        ]);

        // ✅ Single status per order (not pipe-separated)
        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
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

    // public function downloadInvoice($id)
    // {
    //     $order = OrderDetail::with(['country', 'state', 'city'])->findOrFail($id);

    //     $productIds = explode('|', $order->product_id ?? '');
    //     $quantities = explode('|', $order->product_quantity ?? '');
    //     $prices     = explode('|', $order->product_total_price ?? '');
    //     $sizes      = explode('|', $order->size ?? '');

    //     $products = collect($productIds)->map(fn($pid) => Product::find($pid));

    //     $productTotal = array_sum(array_map('floatval', $prices));
    //     $deliveryTotal = floatval($order->total_delivery_charge ?? 0);
    //     $grandTotal = floatval($order->grand_total ?? ($productTotal + $deliveryTotal));

    //     $site_logo_id = get_static_option('site_logo');
    //     $site_logo = get_attachment_image_by_id($site_logo_id, null, true);
    //     $site_logo_url = $site_logo['img_url'] ?? null;

    //     $pdf = Pdf::loadView('backend.pages.orders.invoice', compact(
    //         'order',
    //         'products',
    //         'quantities',
    //         'prices',
    //         'sizes',
    //         'productTotal',
    //         'deliveryTotal',
    //         'grandTotal',
    //         'site_logo_url'
    //     ));

    //     return $pdf->download('invoice-order-' . $order->id . '.pdf');
    // }

    public function downloadInvoice($id)
    {
        $order = OrderDetail::with(['country', 'state', 'city'])->findOrFail($id);

        $productIds = explode('|', $order->product_id ?? '');
        $quantities = explode('|', $order->product_quantity ?? '');
        $prices     = explode('|', $order->product_total_price ?? '');
        $sizes      = explode('|', $order->size ?? '');

        $products = collect($productIds)->map(fn($pid) => Product::find($pid));

        $gstPercents = [];
        $gstAmounts  = [];

        foreach ($products as $index => $product) {
            $price = floatval($prices[$index] ?? 0);
            $gstPercent = floatval($product->gst ?? 0); 
            $gstPercents[$index] = $gstPercent;
            $gstAmounts[$index] = ($price * $gstPercent) / (100 + $gstPercent);  
        }

        $productTotal = array_sum(array_map('floatval', $prices));
        $totalGST     = array_sum($gstAmounts);
        $deliveryTotal = floatval($order->total_delivery_charge ?? 0);
        $grandTotal = floatval($order->grand_total ?? ($productTotal + $deliveryTotal + $totalGST));

        $site_logo_id = get_static_option('site_logo');
        $site_logo = get_attachment_image_by_id($site_logo_id, null, true);
        $site_logo_url = $site_logo['img_url'] ?? null;

        $pdf = Pdf::loadView('backend.pages.orders.invoice', compact(
            'order',
            'products',
            'quantities',
            'prices',
            'sizes',
            'gstPercents',
            'gstAmounts',
            'productTotal',
            'totalGST',
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

    public function downloadShippingBill(OrderDetail $order)
    {
        $user = $order->user; // Assuming 'user' relationship exists
        $identity = $user->identityVerification; // Assuming 'identityVerification' relationship exists

        $userName = $user->first_name . ' ' . $user->last_name;
        $userAddress = $order->address . ', ' . $order->city . ', ' . $order->state . ', ' . $order->country;

        $phone = $user->phone ?? 'N/A';
        $zipCode = $identity->zip_code ?? $order->zipcode; // fallback to order zipcode if not found

        $pdf = Pdf::loadView('backend.pages.orders.shipping-bill', compact('order', 'userName', 'userAddress', 'phone', 'zipCode'));
        return $pdf->stream('shipping-bill-order-' . $order->id . '.pdf');
    }

}
