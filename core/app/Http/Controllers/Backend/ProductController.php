<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('backend.pages.products.product-index', compact('products'));
    }

    public function addProduct()
    {
        $categories = ProductCategory::all();
        return view('backend.pages.products.add-product', compact('categories'));
    }

    // public function storeProduct(Request $request)
    // {
    //     // 1) Validate all fields, including the hidden “image” input
    //     $data = $request->validate([
    //         'name'             => 'required|string|max:255',
    //         'price'            => 'required|numeric|min:0',
    //         'distributor_price'=> 'required|numeric|min:0',
    //         'bv_points'        => 'nullable|integer|min:0',
    //         'stock'            => 'required|integer|min:0',
    //         'weight'           => 'nullable|numeric|min:0',
    //         'gst'              => 'nullable|numeric|min:0|max:100',
    //         'category'         => 'required|exists:product_categories,id',
    //         'description'      => 'nullable|string',
    //         'featured_image'   => 'nullable|integer',   
    //         'image'            => 'nullable|string',    
    //     ]);

    //     // 2) Create the product itself
    //     $product = Product::create([
    //         'name'              => $data['name'],
    //         'price'             => $data['price'],
    //         'distributor_price' => $data['distributor_price'],
    //         'bv_points'         => $data['bv_points'] ?? 0,
    //         'stock'             => $data['stock'],
    //         'weight'            => $data['weight'] ?? 0,
    //         'gst'               => $data['gst'] ?? 0,
    //         'category_id'       => $data['category'],
    //         'description'       => $data['description'] ?? null,
    //         'image'             => $data['image'] ?? null,
    //     ]);

    //     // 3) Attach featured image ID in its own relation if desired
    //     if (!empty($data['featured_image'])) {
    //         $product->attachMedia($data['featured_image'], 'featured');
    //     }

    //     // 4) (Optional) If you still have gallery[] file inputs, handle them here…

    //     return redirect()
    //         ->route('admin.products.add')
    //         ->with('success', 'Product created successfully!');
    // }

    
    
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
            'category'          => 'required|exists:categories,id',
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
            'category_id'       => $request->category,
            'description'       => $request->description,
            'image'             => $image,
        ]);

        Log::info('Product Created:', $product->toArray());

        // ✅ Return JSON for AJAX success (Dropzone style)
        return response()->json([
            'success' => true,
            'redirect' => route('admin.products.index'),
            'message' => 'Product saved successfully!',
        ]);
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
