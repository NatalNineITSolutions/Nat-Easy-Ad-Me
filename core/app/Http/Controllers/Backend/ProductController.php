<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index()
    {
        return view('backend.pages.products.product-index');
    }

    public function addProduct()
    {
        return view('backend.pages.products.add-product');
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
