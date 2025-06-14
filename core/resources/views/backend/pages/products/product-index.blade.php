@extends('backend.admin-master')
@section('site-title')
    {{ __('All Products') }}
@endsection

<style>
    .icons {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Products</h5>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.products.add') }}" class="btn btn-primary">
                Add Product
            </a>
        </div>

        <table class="table table-bordered mt-25">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Product Rows -->
                <tr id="product-row-1">
                    <td>1</td>
                    <td>iPhone 14 Pro</td>
                    <td>Electronics</td>
                    <td>₹1,29,999</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td class="icons">
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-product" data-id="1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr id="product-row-2">
                    <td>2</td>
                    <td>Levi's Denim Jacket</td>
                    <td>Clothing</td>
                    <td>₹3,499</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td class="icons">
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-product" data-id="2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr id="product-row-3">
                    <td>3</td>
                    <td>Prestige Cooker</td>
                    <td>Home & Kitchen</td>
                    <td>₹2,200</td>
                    <td><span class="badge bg-danger">Inactive</span></td>
                    <td class="icons">
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-product" data-id="3">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection