<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Products - Branch Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        <!-- Product Upload Form -->
        <div class="upload-container">
            <h2 class="section-title">Product Information</h2>
            
            <form id="productUploadForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" id="productName" class="form-input" placeholder="Enter product name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productSku" class="form-label">SKU</label>
                        <input type="text" id="productSku" class="form-input" placeholder="Product SKU" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productCategory" class="form-label">Category</label>
                        <select id="productCategory" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="home">Home & Kitchen</option>
                            <option value="beauty">Beauty</option>
                            <option value="sports">Sports & Outdoors</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="productPrice" class="form-label">Price ($)</label>
                        <input type="number" id="productPrice" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productStock" class="form-label">Stock Quantity</label>
                        <input type="number" id="productStock" class="form-input" placeholder="0" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="productStatus" class="form-label">Status</label>
                        <select id="productStatus" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="outofstock">Out of Stock</option>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea id="productDescription" class="form-textarea" placeholder="Enter product description"></textarea>
                    </div>
                    
                    <!-- Image Upload Section -->
                    <div class="form-group full-width">
                        <label class="form-label">Product Images</label>
                        <div class="image-upload-container" id="dropZone">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p class="upload-text">Drag & drop images here or click to browse</p>
                            <p class="upload-hint">Supported formats: JPG, PNG, GIF. Max file size: 5MB</p>
                            <input type="file" id="fileInput" multiple accept="image/*" style="display: none;">
                        </div>
                        
                        <div class="image-preview-container" id="imagePreviewContainer">
                            <!-- Image previews will be added here -->
                        </div>
                    </div>
                    
                    <!-- Product Variants -->
                    <div class="form-group full-width">
                        <label class="form-label">Product Variants</label>
                        <div class="variants-container">
                            <div class="variant-item">
                                <div style="flex: 1;">
                                    <label class="form-label">Color</label>
                                    <input type="text" class="form-input" placeholder="Color variant">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label">Size</label>
                                    <input type="text" class="form-input" placeholder="Size variant">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label">Additional Price</label>
                                    <input type="number" class="form-input" placeholder="0.00" step="0.01" min="0">
                                </div>
                                <button type="button" class="remove-variant">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline" id="addVariant">
                            <i class="fas fa-plus"></i> Add Variant
                        </button>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-outline">
                        <i class="fas fa-save"></i> Save Draft
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Product
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('branchSidebar').classList.toggle('open');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 1024) {
                if (!e.target.closest('#branchSidebar') && !e.target.closest('#sidebarToggle')) {
                    document.getElementById('branchSidebar').classList.remove('open');
                }
            }
        });
        
        // Image upload functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        
        // Open file dialog when clicking on drop zone
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', handleFiles);
        
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropZone.classList.add('dragover');
        }
        
        function unhighlight() {
            dropZone.classList.remove('dragover');
        }
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles({ target: { files } });
        }
        
        function handleFiles(e) {
            const files = e.target.files || e.dataTransfer.files;
            
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Check if file is an image
                    if (!file.type.match('image.*')) {
                        alert('Please upload only image files.');
                        continue;
                    }
                    
                    // Check file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size exceeds 5MB. Please choose a smaller file.');
                        continue;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const imagePreview = document.createElement('div');
                        imagePreview.className = 'image-preview';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('div');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.addEventListener('click', function() {
                            imagePreview.remove();
                        });
                        
                        imagePreview.appendChild(img);
                        imagePreview.appendChild(removeBtn);
                        imagePreviewContainer.appendChild(imagePreview);
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
        }
        
        // Add variant functionality
        const addVariantBtn = document.getElementById('addVariant');
        const variantsContainer = document.querySelector('.variants-container');
        
        addVariantBtn.addEventListener('click', function() {
            const variantItem = document.createElement('div');
            variantItem.className = 'variant-item';
            variantItem.innerHTML = `
                <div style="flex: 1;">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-input" placeholder="Color variant">
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Size</label>
                    <input type="text" class="form-input" placeholder="Size variant">
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Additional Price</label>
                    <input type="number" class="form-input" placeholder="0.00" step="0.01" min="0">
                </div>
                <button type="button" class="remove-variant">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            variantItem.querySelector('.remove-variant').addEventListener('click', function() {
                variantItem.remove();
            });
            
            variantsContainer.appendChild(variantItem);
        });
        
        // Remove variant event listeners
        document.querySelectorAll('.remove-variant').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.variant-item').remove();
            });
        });
        
        // Form submission
        document.getElementById('productUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would normally handle the form submission to your backend
            alert('Product uploaded successfully!');
            // Reset form or redirect as needed
        });
    });
</script>
</body>
</html>