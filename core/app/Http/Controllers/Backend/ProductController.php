<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Models\Unit;
use App\Models\Size;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'imageFile', 'unit'])->get();
        return view('backend.pages.products.product-index', compact('products'));
    }

    public function addProduct()
    {
        $categories = ProductCategory::all();
        $units = Unit::all(); 
        $sizes = Size::all(); 
        return view('backend.pages.products.add-product', compact('categories', 'units', 'sizes'));
    }
    
    public function storeProduct(Request $request)
    {
        Log::info('Product form submission:', $request->all());

        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'price'              => 'required|numeric',
            'distributor_price'  => 'required|numeric',
            'bv_points'          => 'nullable|numeric',
            'stock'              => 'required|integer',
            'gst'                => 'nullable|numeric',
            'unit_id'            => 'required|exists:units,id',
            'unit_measurement'   => 'required|numeric|min:0',
            'category_id'        => 'required|integer|exists:product_categories,id',
            'description'        => 'nullable|string',
            'image'              => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => [
                    'file' => $validator->errors()->all()
                ]
            ], 422);
        }

        $image = $request->filled('image') ? $request->input('image') : null;
        $sizeNames  = $request->input('size_id', []);
        $sizePrices = $request->input('size_price', []);
        $sizeStocks = $request->input('size_stock', []);

        $product = Product::create([
            'name'               => $request->name,
            'price'              => $request->price,
            'distributor_price'  => $request->distributor_price,
            'bv_points'          => $request->bv_points ?? 0,
            'stock'              => $request->stock,
            'gst'                => $request->gst ?? 0,
            'category_id'        => $request->category_id,
            'unit_id'            => $request->unit_id,
            'unit_measurement'   => $request->unit_measurement,
            'description'        => $request->description,
            'image'              => $image,
            'size_id'     => implode('|', $sizeNames),
            'size_price'  => implode('|', $sizePrices),
            'size_stock'  => implode('|', $sizeStocks),
        ]);

        Log::info('Product Created:', $product->toArray());

        return redirect()->route('admin.products.index')->with('message', 'Product saved successfully!');
    }

    public function editProduct($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::all();
        $units      = Unit::all();
        $sizes      = Size::all(); // ✅ Add this line

        return view('backend.pages.products.add-product', compact('product', 'categories', 'units', 'sizes'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric',
            'distributor_price' => 'required|numeric',
            'bv_points'         => 'nullable|numeric',
            'stock'             => 'required|integer',
            'gst'               => 'nullable|numeric',
            'unit_id'           => 'required|exists:units,id',
            'unit_measurement'  => 'required|numeric|min:0',
            'category_id'       => 'required|integer|exists:product_categories,id',
            'description'       => 'nullable|string',
            'image'             => 'nullable|string',
            'size_id'      => 'array',
            'size_id.*'    => 'nullable|exists:sizes,id',
            'size_price'   => 'array',
            'size_price.*' => 'nullable|numeric',
            'size_stock'   => 'array',
            'size_stock.*' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $image = $request->filled('image') ? $request->input('image') : $product->image;

        $product->update([
            'name'              => $request->name,
            'price'             => $request->price,
            'distributor_price' => $request->distributor_price,
            'bv_points'         => $request->bv_points ?? 0,
            'stock'             => $request->stock,
            'gst'               => $request->gst ?? 0,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'unit_measurement'  => $request->unit_measurement,
            'description'       => $request->description,
            'image'             => $image,
            'size_id'     => $request->filled('size_id') ? implode('|', $request->size_id) : null,
            'size_price'  => $request->filled('size_price') ? implode('|', $request->size_price) : null,
            'size_stock'  => $request->filled('size_stock') ? implode('|', $request->size_stock) : null,
        ]);

        return redirect()->route('admin.products.index')
                        ->with('message','Product updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('message', 'Product deleted successfully.'); 
    }

    // Product Category
    public function categoryIndex()
    {
        $categories = ProductCategory::latest()->get();
        return view('backend.pages.products.category-index', compact('categories'));
    }

    public function addCategory()
    {
        return view('backend.pages.products.add-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255|unique:product_categories,category',
        ]);

        ProductCategory::create([
            'category' => $request->category,
        ]);

        return redirect()->route('admin.products.category.index')->with('success', 'Category added successfully!');
    }

    public function editCategory($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('backend.pages.products.add-category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category = ProductCategory::findOrFail($id);
        $category->category = $request->category;
        $category->save();

        return redirect()->route('admin.products.category.index')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.']);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

}
