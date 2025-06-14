@extends('backend.admin-master')
@section('site-title')
    {{ __('Add Product') }}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Add Product</h5>
        </div>

        <form class="mt-25" method="POST" action="#" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Distributor Price (₹)</label>
                <input type="number" step="0.01" name="distributor_price" class="form-control" placeholder="Enter distributor price" required>
            </div>

            <div class="mb-3">
                <label class="form-label">BV Points</label>
                <input type="number" step="1" name="bv_points" class="form-control" placeholder="Enter BV points">
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Available stock" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" class="form-control" placeholder="Enter weight">
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="1">Health</option>
                    <option value="2">Beauty</option>
                    <option value="3">Electronics</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Featured Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Gallery Images</label>
                <input type="file" name="gallery[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if($errors->any())
                toastr.error("{{ $errors->first() }}");
            @endif
        });
    </script>
@endsection

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>