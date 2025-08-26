<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Products - Branch Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

    <x-branch.css />

    <style>
        :root {
            --primary-color: #4A6CF7;
            --secondary-color: #64748B;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
            --dark-color: #1E293B;
            --light-color: #F8FAFC;
            --border-color: #E2E8F0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #F1F5F9;
            color: var(--dark-color);
        }
        
        .branch-dashboard {
            min-height: 100vh;
        }
        
        /* Header Styles */
        .branch-header {
            background: linear-gradient(135deg, var(--primary-color), #2D4FCC);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }
        
        .branch-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .branch-logo {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .branch-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .branch-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        /* Sidebar Styles */
        .branch-sidebar {
            background: white;
            width: 280px;
            height: calc(100vh - 80px);
            position: fixed;
            left: 0;
            top: 80px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 99;
        }
        
        .sidebar-menu {
            padding: 1.5rem 0;
        }
        
        .menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: #F8FAFC;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }
        
        .menu-item i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Area */
        .branch-main-content {
            margin-left: 280px;
            padding: 2rem;
            margin-top: 10px;
        }
        
        /* Product Upload Styles */
        .upload-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        /* Image Upload Styles */
        .image-upload-container {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .image-upload-container:hover {
            border-color: var(--primary-color);
        }
        
        .image-upload-container.dragover {
            border-color: var(--primary-color);
            background-color: rgba(74, 108, 247, 0.05);
        }
        
        .upload-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .upload-text {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .upload-hint {
            font-size: 0.875rem;
            color: var(--secondary-color);
        }
        
        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .image-preview {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .image-preview img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--danger-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-success {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--dark-color);
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
        
        /* Variants Section */
        .variants-container {
            background-color: #F8FAFC;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .variant-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .variant-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .remove-variant {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1.25rem;
            align-self: center;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .branch-sidebar {
                transform: translateX(-100%);
            }
            
            .branch-sidebar.open {
                transform: translateX(0);
            }
            
            .branch-main-content {
                margin-left: 0;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .branch-header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .branch-main-content {
                padding: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        @media (max-width: 1024px) {
            .menu-toggle {
                display: block;
            }
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide arrows for Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
        <h1 class="mb-4">Upload Product</h1>

        @if(session('message'))
            <div class="alert alert-success mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if($errors->has('error'))
            <div class="alert alert-danger mb-4">
                {{ $errors->first('error') }}
            </div>
        @endif
        
        <!-- Product Upload Form -->
        <div class="upload-container">
            <h2 class="section-title">Product Information</h2>
            
            <form id="productUploadForm" action="{{ route('branch.products.store') }}" method="POST">
                @csrf
                <div class="form-grid">

                    <!-- Vendor -->
                    <div class="form-group">
                        <label for="vendor" class="form-label">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-select" required>
                            <option value="">Select a Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">
                                    {{ $vendor->company_name }} ({{ $vendor->primary_contact_name }}) - {{ $vendor->vendor_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" id="productName" name="name" class="form-input" placeholder="Enter product name" required>
                    </div>

                    <!-- Weight -->
                    <div class="form-group">
                        <label for="weight" class="form-label">Weight (grams)</label>
                        <input type="number" step="0.01" id="weight" name="weight" class="form-input" placeholder="Enter product weight in grams">
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" id="stock" name="stock" class="form-input" placeholder="Available stock" min="0" required>
                    </div>

                    <!-- Unit -->
                    <div class="form-group">
                        <label for="unit" class="form-label">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-select" required>
                            <option value="">Select a Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unit Measurement -->
                    <div class="form-group">
                        <label for="unitMeasurement" class="form-label">Unit Measurement</label>
                        <input type="number" step="0.01" id="unitMeasurement" name="unit_measurement" class="form-input" placeholder="Enter unit measurement" min="0" required>
                    </div>

                    <!-- GST -->
                    <div class="form-group">
                        <label for="gst" class="form-label">GST (%)</label>
                        <input type="number" step="0.01" id="gst" name="gst" class="form-input" placeholder="Enter GST percent" min="0">
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="form-group full-width">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-textarea" placeholder="Enter product description"></textarea>
                    </div>

                    <!-- Variants -->
                    <div class="form-group full-width">
                        <label class="form-label">Product Variants (Size-based)</label>
                        
                        <div class="variants-container" id="variantWrapper">
                            <div class="variant-item" style="display: flex; gap: 10px; align-items: flex-end; margin-bottom: 10px;">
                                <div style="flex: 1;">
                                    <label class="form-label">Size</label>
                                    <select name="variants[size][]" class="form-input">
                                        <option value="">Select Size</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label">Additional Price</label>
                                    <input type="number" step="0.01" name="variants[price][]" class="form-input" placeholder="0.00">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="variants[stock][]" class="form-input" placeholder="0">
                                </div>
                                <button type="button" class="remove-variant" style="background: red; color: #fff; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline" id="addVariant">
                            <i class="fas fa-plus"></i> Add Variant
                        </button>
                    </div>
                    
                    <div class="upload-img text-center mt-3">
                        <div class="media-upload-btn-wrapper">
                            <div class="img-wrap new_image_add_listing">
                                <img
                                    src="{{ asset('assets/common/img/listing_single_image.jpg') }}"
                                    class="w-100"
                                    style="max-height: 200px; object-fit: contain;">
                            </div>
                            <input
                                type="hidden"
                                name="image"
                                value="">
                            <button
                                type="button"
                                class="btn btn-info media_upload_form_btn"
                                data-bs-toggle="modal"
                                data-bs-target="#branch_media_upload_modal">
                                Click to browse & Upload Featured Image
                            </button>
                            <small>{{ __('image format: jpg,jpeg,png,gif,webp') }}</small><br>
                            <small>{{ __('recommended size 810x450') }}</small>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Product</button>
                </div>
            </form>

        </div>
    </main>

    <x-branch.markup />

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<x-branch.js  />


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const wrapper = document.getElementById("variantWrapper");
        const addBtn = document.getElementById("addVariant");

        // Get the size options from server-rendered select (first dropdown)
        const sizeOptions = document.querySelector("select[name='variants[size][]']").innerHTML;

        // Function to create new variant row
        function createVariantRow() {
            const div = document.createElement("div");
            div.classList.add("variant-item");
            div.style.display = "flex";
            div.style.gap = "10px";
            div.style.alignItems = "flex-end";
            div.style.marginBottom = "10px";

            div.innerHTML = `
                <div style="flex: 1;">
                    <label class="form-label">Size</label>
                    <select name="variants[size][]" class="form-input">
                        ${sizeOptions}
                    </select>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Additional Price</label>
                    <input type="number" step="0.01" name="variants[price][]" class="form-input" placeholder="0.00">
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Stock</label>
                    <input type="number" name="variants[stock][]" class="form-input" placeholder="0">
                </div>
                <button type="button" class="remove-variant" style="background: red; color: #fff; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            `;

            // Attach remove functionality
            div.querySelector(".remove-variant").addEventListener("click", function () {
                div.remove();
            });

            return div;
        }

        // Add new variant
        addBtn.addEventListener("click", function () {
            wrapper.appendChild(createVariantRow());
        });

        // Enable remove for the first (default) row
        document.querySelectorAll(".remove-variant").forEach(btn => {
            btn.addEventListener("click", function () {
                btn.closest(".variant-item").remove();
            });
        });
    });
</script>

<script>
    // Extra safeguard to prevent typing negative values
    document.querySelectorAll("input[type=number]").forEach(input => {
        input.addEventListener("input", function () {
            if (this.value < 0) this.value = 0;
        });
    });
</script>

<script>
    Dropzone.autoDiscover = false; // <--- ADD THIS LINE
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("branch_media_upload_modal");

        modal.addEventListener("shown.bs.modal", function () {
            if (!modal.dropzoneInitialized) {
                new Dropzone("#branchPlaceholderForm", {
                    paramName: "file",
                    maxFilesize: 10, // MB
                    acceptedFiles: "image/*",
                    addRemoveLinks: true,
                    dictDefaultMessage: "Drop files here to upload Support Formats (jpg, png, jpeg, gif)",
                });
                modal.dropzoneInitialized = true;
            }
        });
    });
</script>


</body>
</html>