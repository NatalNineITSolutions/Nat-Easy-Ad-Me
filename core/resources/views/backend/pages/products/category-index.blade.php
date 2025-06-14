@extends('backend.admin-master')
@section('site-title')
    {{__('All Categories')}}
@endsection

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Product Categories</h5>
        </div>

        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.products.category.add') }}" class="btn btn-primary">
                Add Category
            </a>
        </div>

        <table class="table table-bordered mt-25">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                    <tr id="category-row-{{ $category->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->category }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.products.category.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm delete-category" data-id="{{ $category->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

{{-- Delete Func --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-category").forEach(function (button) {
            button.addEventListener("click", function () {
                let categoryId = this.getAttribute("data-id");
                let url = "{{ route('admin.products.category.delete', ':id') }}".replace(':id', categoryId);

                if (confirm("Are you sure you want to delete this category?")) {
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("category-row-" + categoryId).remove(); // Remove from DOM
                            alert(data.message);
                        } else {
                            alert("Something went wrong!");
                        }
                    })
                    .catch(error => {
                        alert("Failed to delete category.");
                    });
                }
            });
        });
    });
</script>
