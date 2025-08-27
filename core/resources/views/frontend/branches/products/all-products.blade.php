<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Branch Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <x-branch.css />

    <style>
        body {
            background-color: #F1F5F9;
            font-family: 'Inter', sans-serif;
        }

        .branch-main-content {
            margin-left: 280px;
            padding: 2rem;
            margin-top: 10px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
            border-radius: 8px;
        }

        .badge-success {
            background-color: #10B981;
            color: white;
        }

        .badge-danger {
            background-color: #EF4444;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<div class="branch-dashboard">
    <!-- Header -->
    @include('frontend.branches.partials.header')

    <!-- Sidebar -->
    @include('frontend.branches.partials.sidebar')

    <!-- Main Content -->
    <main class="branch-main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>All Products</h1>
            <a href="{{ route('branch.upload.products') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>

        <div class="table-container">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <!-- Product Image -->
                            <td class="d-flex align-items-center gap-3">
                                <img src="{{ $product->imageFile ? asset('assets/uploads/media-uploader/'.$product->imageFile->path) : asset('assets/uploads/media-uploader/default-product.png') }}"
                                    alt="{{ $product->name }}"
                                    style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                {{ $product->name }}
                            </td>

                            <!-- Name -->
                            <td>{{ $product->name }}</td>

                            <!-- Category -->
                            <td>{{ $product->category->category ?? 'N/A' }}</td>

                            <!-- Status -->
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-center">
                                <a href="{{ route('branch.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('branch.products.delete', $product->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<x-branch.js />
</body>
</html>
