<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('imageFile')->get();
        return view('backend.pages.products.product-index', compact('products'));
    }

    public function addProduct()
    {
        $categories = ProductCategory::all();
        return view('backend.pages.products.add-product', compact('categories'));
    }

    
    public function storeProduct(Request $request)
    {
        Log::info('Product form submission:', $request->all());

        // ✅ Validate inputs
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric',
            'distributor_price' => 'required|numeric',
            'bv_points'         => 'nullable|numeric',
            'stock'             => 'required|integer',
            'weight'            => 'nullable|numeric',
            'gst'               => 'nullable|numeric',
            'category_id' => 'required|integer|exists:product_categories,id',
            'description'       => 'nullable|string',
            'image'             => 'nullable|string', // could be an ID or path
        ]);

        if ($validator->fails()) {
            // ✅ Return consistent JSON structure Dropzone expects
            return response()->json([
                'errors' => [
                    'file' => $validator->errors()->all()
                ]
            ], 422);
        }

        // ✅ Safely extract image if present
        $image = $request->filled('image') ? $request->input('image') : null;

        // ✅ Create product
        $product = Product::create([
            'name'              => $request->name,
            'price'             => $request->price,
            'distributor_price' => $request->distributor_price,
            'bv_points'         => $request->bv_points ?? 0,
            'stock'             => $request->stock,
            'weight'            => $request->weight ?? 0,
            'gst'               => $request->gst ?? 0,
            'category_id' => $request->category_id,
            'description'       => $request->description,
            'image'             => $image,
        ]);

        Log::info('Product Created:', $product->toArray());

        // ✅ Return JSON for AJAX success (Dropzone style)
        return redirect()->route('admin.products.index')->with('message', 'Product saved successfully!');
    }

    public function editProduct($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('backend.pages.products.add-product', compact('product','categories'));
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
            'weight'            => 'nullable|numeric',
            'gst'               => 'nullable|numeric',
            'category_id'       => 'required|integer|exists:product_categories,id',
            'description'       => 'nullable|string',
            'image'             => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Safely handle image update - only update if new image is provided
        $image = $request->filled('image') ? $request->input('image') : $product->image;

        $product->update([
            'name'              => $request->name,
            'price'             => $request->price,
            'distributor_price' => $request->distributor_price,
            'bv_points'         => $request->bv_points ?? 0,
            'stock'             => $request->stock,
            'weight'            => $request->weight ?? 0,
            'gst'               => $request->gst ?? 0,
            'category_id'       => $request->category_id,
            'description'       => $request->description,
            'image'             => $image, // Use the new image or keep the existing one
        ]);

        return redirect()->route('admin.products.index')
                        ->with('message','Product updated successfully!');
    }
    
    // public function destroy(int $id): RedirectResponse
    // {
    //     $product = Product::findOrFail($id);
    //     $product->delete();

    //     return redirect()
    //         ->route('admin.products.index')
    //         ->with('success', 'Product deleted successfully.');
    // }

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
