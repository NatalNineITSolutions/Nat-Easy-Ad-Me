@extends('backend.admin-master')

@section('site-title')
    {{ isset($product) ? __('Edit Product') : __('Add Product') }}
@endsection

@section('style')
    <!-- Media Modal CSS -->
    <x-media.css />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .modal-body .tab-content {
            padding: 15px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .media-uploader-image-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px,1fr));
            gap: 15px;
            padding: 0;
            list-style: none;
        }
        .media-uploader-image-list li {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all .3s ease;
        }
        .media-uploader-image-list li.selected {
            border-color: #0d6efd;
        }
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            min-height: 150px;
            padding: 20px;
        }
        .image-preloader-wrapper {
            display: none;
            text-align: center;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-4">
                {{ isset($product) ? __('Edit Product') : __('Add Product') }}
            </h5>

            @php
                $isEdit    = isset($product);
                $formRoute = $isEdit
                    ? route('admin.products.update', $product->id)
                    : route('admin.products.store');
            @endphp

            <form method="POST" action="{{ $formRoute }}" enctype="multipart/form-data">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Product Name --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="{{ __('Enter product name') }}"
                        value="{{ old('name', $product->name ?? '') }}"
                        required>
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Price (₹)') }}</label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control"
                        placeholder="{{ __('Enter price') }}"
                        value="{{ old('price', $product->price ?? '') }}"
                        required>
                </div>

                {{-- Distributor Price --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Distributor Price (₹)') }}</label>
                    <input
                        type="number"
                        step="0.01"
                        name="distributor_price"
                        class="form-control"
                        placeholder="{{ __('Enter distributor price') }}"
                        value="{{ old('distributor_price', $product->distributor_price ?? '') }}"
                        required>
                </div>

                {{-- BV Points --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('BV Points') }}</label>
                    <input
                        type="number"
                        step="1"
                        name="bv_points"
                        class="form-control"
                        placeholder="{{ __('Enter BV points') }}"
                        value="{{ old('bv_points', $product->bv_points ?? '') }}">
                </div>

                {{-- Stock --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        placeholder="{{ __('Available stock') }}"
                        value="{{ old('stock', $product->stock ?? '') }}"
                        required>
                </div>

                {{-- Unit --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Unit') }}</label>
                    <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                        <option value="">{{ __('Select a Unit') }}</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Unit Measurement --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Unit Measurement') }}</label>
                    <input
                        type="number"
                        step="0.01"
                        name="unit_measurement"
                        class="form-control"
                        placeholder="{{ __('Enter unit measurement') }}"
                        value="{{ old('unit_measurement', $product->unit_measurement ?? '') }}"
                        required>
                    @error('unit_measurement')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @php
                    $existingSizes = isset($product) && $product->size_id ? explode('|', $product->size_id) : [];
                    $existingPrices = isset($product) && $product->size_price ? explode('|', $product->size_price) : [];
                    $existingStocks = isset($product) && $product->size_stock ? explode('|', $product->size_stock) : [];
                @endphp

                {{-- Variant Section --}}
                <div class="card mt-4 mb-3">
                    <div class="card-header bg-light">
                        <strong>{{ __('Variant (Size-based Pricing & Stock)') }}</strong>
                    </div>
                    <div class="card-body">
                        <div id="variant-wrapper">
                            {{-- initial variant – no trash here --}}
                            {{-- <div class="variant-box mb-3 border rounded p-3 position-relative">
                                <div class="row g-3 align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Item Size') }}</label>
                                    <select name="size_id[]" class="form-control" required>
                                        <option value="">{{ __('Select Size') }}</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Additional Price') }}</label>
                                    <input type="number" step="0.01" name="size_price[]" class="form-control" placeholder="e.g. 50">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">{{ __('Stock Count') }}</label>
                                    <input type="number" name="size_stock[]" class="form-control" placeholder="e.g. 25">
                                </div>
                                </div>
                            </div> --}}
                            @foreach($existingSizes as $index => $sizeId)
                                <div class="variant-box mb-3 border rounded p-3 position-relative">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-2">
                                            <label class="form-label">{{ __('Item Size') }}</label>
                                            <select name="size_id[]" class="form-control" required>
                                                <option value="">{{ __('Select Size') }}</option>
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ $size->id == $sizeId ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">{{ __('Additional Price') }}</label>
                                            <input type="number" step="0.01" name="size_price[]" class="form-control" placeholder="e.g. 50" value="{{ $existingPrices[$index] ?? '' }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">{{ __('Stock Count') }}</label>
                                            <input type="number" name="size_stock[]" class="form-control" placeholder="e.g. 25" value="{{ $existingStocks[$index] ?? '' }}">
                                        </div>
                                        @if($index > 0)
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-variant" style="height: 38px;">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-secondary btn-sm" id="add-variant-btn">
                                <i class="las la-plus"></i> {{ __('Add Variant') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- GST --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('GST (%)') }}</label>
                    <input
                        type="number"
                        step="0.01"
                        name="gst"
                        class="form-control"
                        placeholder="{{ __('Enter GST percent') }}"
                        value="{{ old('gst', $product->gst ?? 0) }}">
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $cat)
                            <option
                                value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Description') }}</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="{{ __('Enter product description') }}">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                {{-- Featured Image --}}
                <div class="upload-img text-center mt-3">
                    <div class="media-upload-btn-wrapper">
                        <div class="img-wrap new_image_add_listing">
                            @if($isEdit && $product->imageFile && $product->imageFile->path)
                                <img
                                    src="{{ asset('assets/uploads/media-uploader/'.$product->imageFile->path) }}"
                                    class="w-100"
                                    style="max-height: 200px; object-fit: contain;">
                            @else
                                <img
                                    src="{{ asset('assets/common/img/listing_single_image.jpg') }}"
                                    class="w-100"
                                    style="max-height: 200px; object-fit: contain;">
                            @endif
                        </div>
                        <input
                            type="hidden"
                            name="image"
                            value="{{ old('image', $product->image ?? '') }}">
                        <button
                            type="button"
                            class="btn btn-info media_upload_form_btn"
                            data-btntitle="{{ __('Select Image') }}"
                            data-modaltitle="{{ __('Upload Image') }}"
                            data-bs-toggle="modal"
                            data-bs-target="#media_upload_modal">
                            {{ __('Click to browse & Upload Featured Image') }}
                        </button>
                        <small>{{ __('image format: jpg,jpeg,png,gif,webp') }}</small><br>
                        <small>{{ __('recommended size 810x450') }}</small>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary mt-4">
                    {{ $isEdit ? __('Update Product') : __('Save Product') }}
                </button>
            </form>
        </div>
    </div>

    {{-- Media Modal Markup --}}
    <x-media.markup />
@endsection

<script>
    const sizeOptions = @json($sizes->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));

    document.addEventListener('DOMContentLoaded', function () {
        let variantIndex = 1;
        const labels = {
            size: "{{ __('Item Size') }}",
            price: "{{ __('Additional Price') }}",
            stock: "{{ __('Stock Count') }}"
        };

        const addBtn = document.getElementById('add-variant-btn');
        const wrapper = document.getElementById('variant-wrapper');

        function getSizeDropdown() {
            let html = `<select name="size_id[]" class="form-control" required>
                            <option value="">${labels.size}</option>`;
            sizeOptions.forEach(option => {
                html += `<option value="${option.id}">${option.name}</option>`;
            });
            html += `</select>`;
            return html;
        }

        addBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const box = document.createElement('div');
            box.className = 'variant-box mb-3 border rounded p-3 position-relative';
            box.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">${labels.size}</label>
                        ${getSizeDropdown()}
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">${labels.price}</label>
                        <input type="number" step="0.01" name="size_price[]" class="form-control" placeholder="e.g. 50">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">${labels.stock}</label>
                        <input type="number" name="size_stock[]" class="form-control" placeholder="e.g. 25">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-variant" style="height: 38px;">
                            <i class="las la-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            wrapper.appendChild(box);
            variantIndex++;
        });

        wrapper.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-variant');
            if (btn) {
                e.preventDefault();
                btn.closest('.variant-box').remove();
            }
        });
    });
</script>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Media Upload Script --}}
    <x-media.js />

    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    
@endsection