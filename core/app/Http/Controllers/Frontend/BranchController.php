<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Actions\Media\MediaHelper;
use App\Models\Backend\MediaUpload;
use App\Helpers\FlashMsg;
use Intervention\Image\Facades\Image;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class BranchController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:branch');
    // }

    /**
     * Handle branch login (GET and POST requests)
     */
    public function branchlogin(Request $request)
    {
        // Handle GET request - show login form
        if ($request->isMethod('get')) {
            return view('frontend.branches.branchlogin');
        }

        // Handle POST request - process login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate as a branch
        if (Auth::guard('branch')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect to branch dashboard or home page
            return redirect()->intended(route('branch.dashboard'));
        }

        // If authentication fails
        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    /**
     * Branch dashboard (protected route)
     */

    public function allProducts()
    {
        $branchId = auth()->guard('branch')->id();
        $products = Product::where('branch_id', $branchId)
            ->with(['category', 'imageFile']) 
            ->get();

        return view('frontend.branches.products.all-products', compact('products'));
    }

    public function orderHistory()
    {
        $branchId = auth()->guard('branch')->id();

        $orders = \DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'order_details.user_id', '=', 'users.id') // join users table
            ->where('products.branch_id', $branchId)
            ->select(
                'order_details.*',
                'products.name as product_name',
                'products.branch_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'order_details.created_at as order_date'
            )
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('frontend.branches.products.order-history', compact('orders'));
    }
    
    public function downloadInvoice($id)
    {
        // Fetch order details by ID
        $order = OrderDetail::with(['city', 'state', 'country'])->findOrFail($id);

        // Load Blade view into PDF
        $pdf = Pdf::loadView('frontend.branches.products.order-invoice', compact('order'));

        // Download file with dynamic name
        return $pdf->download('invoice-order-' . $order->id . '.pdf');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,packaging,shipped,delivered',
        ]);

        DB::table('order_details')
            ->where('id', $id)
            ->update(['order_status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function branchDashboard()
    {
        $branch = auth('branch')->user();

        return view('frontend.branches.dashboard.dashboard', compact('branch'));
    }

    public function productUpload(Request $request, $id = null)
    {
        $branchId = auth('branch')->id();
        $vendors = Vendor::whereRaw('JSON_CONTAINS(branch_id, ?)', [json_encode((string)$branchId)])->get();
        $categories = ProductCategory::all();
        $units = Unit::all();
        $sizes = Size::all();
        $product = $id ? Product::findOrFail($id) : null; // fetch product if editing

        return view('frontend.branches.products.index', compact('vendors', 'categories', 'units', 'sizes', 'product'));
    }


    public function store(Request $request)
    {
        $branch = auth('branch')->user();

        if (!$branch) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized. Branch not logged in.']);
        }

        // Validate request
        $request->validate([
            'vendor_id'            => 'required|exists:vendors,id',
            'name'                 => 'required|string|max:255',
            'weight'               => 'nullable|numeric|min:0',
            'stock'                => 'required|integer|min:0',
            'unit_id'              => 'required|exists:units,id',
            'unit_measurement'     => 'required|numeric|min:0',
            'gst'                  => 'nullable|numeric|min:0',
            'category_id'          => 'required|exists:product_categories,id',
            'description'          => 'nullable|string',
            'image'                => 'nullable|integer|exists:media_uploads,id', // <-- image as attachment ID
            'variants.size.*'      => 'nullable|exists:sizes,id',
            'variants.price.*'     => 'nullable|numeric|min:0',
            'variants.stock.*'     => 'nullable|integer|min:0',
        ]);

        $sizes  = $request->input('variants.size', []);
        $prices = $request->input('variants.price', []);
        $stocks = $request->input('variants.stock', []);

        $hasVariants = !empty(array_filter($sizes)) || !empty(array_filter($prices)) || !empty(array_filter($stocks));

        try {
            DB::beginTransaction();

            $product = Product::create([
                'vendor_id'        => $request->input('vendor_id'),
                'branch_id'        => $branch->id,
                'name'             => $request->input('name'),
                'price'            => 0,
                'distributor_price'=> 0,
                'bv_points'        => 0,
                'weight'           => $request->input('weight') ?? null,
                'stock'            => $request->input('stock'),
                'unit_id'          => $request->input('unit_id'),
                'unit_measurement' => $request->input('unit_measurement'),
                'gst'              => $request->input('gst') ?? 0,
                'category_id'      => $request->input('category_id'),
                'description'      => $request->input('description') ?? null,
                'image'            => $request->input('image') ?? null, // <-- store image ID
                'size_id'          => $hasVariants ? implode('|', $sizes) : null,
                'size_price'       => $hasVariants ? implode('|', $prices) : null,
                'size_stock'       => $hasVariants ? implode('|', $stocks) : null,
                'is_active'        => 0,
            ]);

            DB::commit();

            Log::info('Branch product created', [
                'branch_id' => $branch->id,
                'product_id' => $product->id,
                'data' => $product->toArray()
            ]);

            return redirect()->back()->with('message', 'Product uploaded successfully! It is currently inactive.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product store failed: ' . $e->getMessage(), [
                'branch_id' => $branch->id,
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->back()->withErrors(['error' => 'Failed to save product. Check logs.']);
        }
    }


    public function edit($id)
    {
        $branchId = auth('branch')->id();
        $product = Product::where('id', $id)->where('branch_id', $branchId)->firstOrFail();

        $vendors = Vendor::whereRaw('JSON_CONTAINS(branch_id, ?)', [json_encode((string)$branchId)])->get();
        $categories = ProductCategory::all();
        $units = Unit::all();
        $sizes = Size::all();

        return view('frontend.branches.products.index', compact('vendors', 'categories', 'units', 'sizes', 'product'));
    }

    public function update(Request $request, $id)
    {
        $branch = auth('branch')->user();
        $product = Product::where('id', $id)->where('branch_id', $branch->id)->firstOrFail();

        $request->validate([
            'vendor_id'            => 'required|exists:vendors,id',
            'name'                 => 'required|string|max:255',
            'weight'               => 'nullable|numeric|min:0',
            'stock'                => 'required|integer|min:0',
            'unit_id'              => 'required|exists:units,id',
            'unit_measurement'     => 'required|numeric|min:0',
            'gst'                  => 'nullable|numeric|min:0',
            'category_id'          => 'required|exists:product_categories,id',
            'description'          => 'nullable|string',
            'image'                => 'nullable|integer|exists:media_uploads,id',
            'variants.size.*'      => 'nullable|exists:sizes,id',
            'variants.price.*'     => 'nullable|numeric|min:0',
            'variants.stock.*'     => 'nullable|integer|min:0',
        ]);

        $sizes  = $request->input('variants.size', []);
        $prices = $request->input('variants.price', []);
        $stocks = $request->input('variants.stock', []);
        $hasVariants = !empty(array_filter($sizes)) || !empty(array_filter($prices)) || !empty(array_filter($stocks));

        try {
            DB::beginTransaction();

            $product->update([
                'vendor_id'        => $request->input('vendor_id'),
                'name'             => $request->input('name'),
                'weight'           => $request->input('weight') ?? null,
                'stock'            => $request->input('stock'),
                'unit_id'          => $request->input('unit_id'),
                'unit_measurement' => $request->input('unit_measurement'),
                'gst'              => $request->input('gst') ?? 0,
                'category_id'      => $request->input('category_id'),
                'description'      => $request->input('description') ?? null,
                'image'            => $request->input('image') ?? null,
                'size_id'          => $hasVariants ? implode('|', $sizes) : null,
                'size_price'       => $hasVariants ? implode('|', $prices) : null,
                'size_stock'       => $hasVariants ? implode('|', $stocks) : null,
            ]);

            DB::commit();

            return redirect()->route('branch.products.all')->with('message', 'Product updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product update failed: ' . $e->getMessage(), [
                'branch_id' => $branch->id,
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->back()->withErrors(['error' => 'Failed to update product. Check logs.']);
        }
    }

    public function destroy($id)
    {
        // Find the produc
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->imageFile) {
            $imagePath = public_path('assets/uploads/media-uploader/' . $product->imageFile->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $product->imageFile()->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('branch.products.all')->with('message', 'Product deleted successfully.');
    }

    /**
     * Branch logout
     */
    public function branchlogout(Request $request)
    {
        Auth::guard('branch')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('branchlogin');
    }

    // Upload single media file
    public function uploadMediaFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'nullable|mimes:jpg,jpeg,png,gif,webp|max:11264'
        ]);
        MediaHelper::insert_media_image($request);
    }

    // Fetch all media files as JSON
    public function allUploadMediaFile(Request $request)
    {
        return response()->json(MediaHelper::fetch_media_image($request));
    }

    // Delete media file
    public function deleteUploadMediaFile(Request $request)
    {
        MediaHelper::delete_media_image($request);
        return redirect()->back()->with(FlashMsg::error('Image Deleted'));
    }

    // Regenerate media images (resizing etc.)
    public function regenerateMediaImages()
    {
        $all_media_file = MediaUpload::all();
        foreach ($all_media_file as $img) {

            if (!file_exists('assets/uploads/media-uploader/' . $img->path)) {
                continue;
            }
            $image = 'assets/uploads/media-uploader/' . $img->path;
            $image_dimension = getimagesize($image);;
            $image_width = $image_dimension[0];
            $image_height = $image_dimension[1];

            $image_db = $img->path;
            $image_grid = 'grid-' . $image_db;
            $image_large = 'large-' . $image_db;
            $image_thumb = 'thumb-' . $image_db;
            $image_semi_large = 'semi-large-' . $image_db;
            $image_tiny = 'tiny-' . $image_db;

            $folder_path = 'assets/uploads/media-uploader/';
            $resize_grid_image = Image::make($image)->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_large_image = Image::make($image)->resize(740, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_semi_large_image = Image::make($image)->resize(540, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_tiny_image = Image::make($image)->resize(15, 15)->blur(50);
            $resize_thumb_image = Image::make($image)->resize(150, 150);

            if ($image_width > 150) {
                $resize_thumb_image->save($folder_path . $image_thumb);
                $resize_grid_image->save($folder_path . $image_grid);
                $resize_large_image->save($folder_path . $image_large);
                $resize_semi_large_image->save($folder_path . $image_semi_large);
                $resize_tiny_image->save($folder_path . $image_tiny);
            }
        }
        return __('regenerate done');
    }

    // Change alt text of image
    public function altChangeUploadMediaFile(Request $request)
    {
        $this->validate($request, [
            'imgid' => 'required',
            'alt' => 'nullable',
        ]);
        MediaUpload::where('id', $request->imgid)->update(['alt' => $request->alt]);
        return __('alt update done');
    }

    // Load all media images for branch page
    public function allUploadMediaImagesForPage()
    {
        $all_media_images = MediaUpload::where(['type' => 'branch'])->orderBy('id', 'desc')->get();
        return view('frontend.branches.media.images')->with(['all_media_images' => $all_media_images]);
    }

    // Load more images (pagination/ajax)
    public function getImageForLoadmore(Request $request)
    {
        return response()->json(MediaHelper::load_more_images($request));
    }
}