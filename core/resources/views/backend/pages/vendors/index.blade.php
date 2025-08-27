@extends('backend.admin-master')
@section('site-title')
    {{__('Vendors Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css />
    <x-media.css />
    <style>
        .debug-panel {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #dc3545;
        }
        .debug-title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .debug-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            max-height: 200px;
            overflow-y: auto;
        }
        .modal-content {
            border-radius: 10px;
            border: none;
        }
        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
        }
        .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 10px 10px;
            padding: 15px 20px;
        }
        .btn-close:focus {
            box-shadow: none;
        }
        .form__input__single {
            margin-bottom: 15px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
            border-color: #4299e1;
        }
        .alert-debug {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons form {
            display: inline;
        }
    </style>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-12 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Vendors Management')}}</h4>
                    </div>
                    <div class="right-content">
                        <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5" data-bs-toggle="modal" data-bs-target="#addVendorModal">
                            <i class="fas fa-plus me-2"></i> {{ __('Add New Vendor') }}
                        </button>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Vendors List -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Vendor ID') }}</th>
                                <th>{{ __('Branches') }}</th>
                                <th>{{ __('Primary Contact') }}</th>
                                <th>{{ __('Company') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Opening Balance') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$vendor->vendor_id}}</td>
                                    <td>
                                        @php
                                            $branchIds = json_decode($vendor->branch_id, true) ?? [];

                                            $branchNames = \App\Models\Branch::whereIn('id', $branchIds)->pluck('name')->toArray();
                                        @endphp

                                        {{ implode(', ', $branchNames) }}
                                    </td>
                                    <td>{{ $vendor->primary_contact_name }}</td>
                                    <td>{{ $vendor->company_name }}</td>
                                    <td>{{ $vendor->email }}</td>
                                    <td>{{ $vendor->phone }}</td>
                                    <td>{{ number_format($vendor->opening_balance, 2) }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-primary btn-sm edit-vendor"
                                                data-bs-toggle="modal" data-bs-target="#editVendorModal"
                                                data-id="{{ $vendor->id }}"
                                                data-primary_contact_name="{{ $vendor->primary_contact_name }}"
                                                data-company_name="{{ $vendor->company_name }}"
                                                data-email="{{ $vendor->email }}"
                                                data-phone="{{ $vendor->phone }}"
                                                data-website="{{ $vendor->website }}"
                                                data-opening_balance="{{ $vendor->opening_balance }}"
                                                data-currency="{{ $vendor->currency }}"
                                                data-billing_address="{{ $vendor->billing_address }}"
                                                data-shipping_address="{{ $vendor->shipping_address }}">
                                                {{ __('Edit') }}
                                            </button>

                                            <form action="{{ route('admin.vendors.delete', $vendor->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('{{ __('Are you sure you want to delete this vendor?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No vendors found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Check if vendors is a LengthAwarePaginator instance before calling hasPages() --}}
                @if(method_exists($vendors, 'hasPages') && $vendors->hasPages())
                    <div class="mt-3">
                        {{ $vendors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Vendor Modal -->
    <div class="modal fade" id="addVendorModal" tabindex="-1" aria-labelledby="addVendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="max-height: 90vh;">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVendorModalLabel">{{ __('Add New Vendor') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.vendors.store')}}" method="POST" id="vendorForm">
                    @csrf
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <x-validation.error />
                        <div class="row">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="primary_contact_name" class="form__input__single__label">{{__('Primary Contact Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="primary_contact_name" id="primary_contact_name" class="form-control radius-5"
                                           value="{{ old('primary_contact_name') }}" placeholder="{{ __('e.g. John Doe') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="company_name" class="form__input__single__label">{{__('Company Name')}}</label>
                                    <input type="text" name="company_name" id="company_name" class="form-control radius-5"
                                           value="{{ old('company_name') }}" placeholder="{{ __('e.g. Acme Corporation') }}">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="email" class="form__input__single__label">{{__('Email Address')}}</label>
                                    <input type="email" name="email" id="email" class="form-control radius-5"
                                           value="{{ old('email') }}" placeholder="{{ __('e.g. vendor@example.com') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="phone" class="form__input__single__label">{{__('Phone')}}</label>
                                    <input type="tel" name="phone" id="phone" class="form-control radius-5"
                                           value="{{ old('phone') }}" placeholder="{{ __('e.g. 9876543210') }}">
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="website" class="form__input__single__label">{{__('Official Website')}}</label>
                                    <input type="url" name="website" id="website" class="form-control radius-5"
                                           value="{{ old('website') }}" placeholder="{{ __('e.g. https://www.example.com') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form__input__single mb-3">
                                    <label for="opening_balance" class="form__input__single__label">{{__('Opening Balance')}}</label>
                                    <input type="number" step="0.01" name="opening_balance" id="opening_balance" class="form-control radius-5"
                                           value="{{ old('opening_balance', '0.00') }}" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form__input__single mb-3">
                                    <label for="currency" class="form__input__single__label">{{__('Currency')}}</label>
                                    <select name="currency" id="currency" class="form-control radius-5">
                                        <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                        <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                        <!-- Add more currencies as needed -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form__input__single mb-3">
                                    <label for="branchDropdown" class="form__input__single__label">{{ __('Select Branches') }}</label>
                                    <select id="branchDropdown" class="form-control">
                                        <option value="">-- Select Branch --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Badges will show here -->
                                <div id="selectedBranches" class="d-flex flex-wrap gap-2"></div>

                                <!-- Hidden inputs go here -->
                                <div id="branchHiddenInputs"></div>
                            </div>

                            <!-- Addresses -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="billing_address" class="form__input__single__label">{{__('Billing Address')}}</label>
                                    <textarea name="billing_address" id="billing_address" class="form-control radius-5" rows="3"
                                              placeholder="{{ __('Enter billing address') }}">{{ old('billing_address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="shipping_address" class="form__input__single__label">{{__('Shipping Address')}}</label>
                                    <textarea name="shipping_address" id="shipping_address" class="form-control radius-5" rows="3"
                                              placeholder="{{ __('Enter shipping address') }}">{{ old('shipping_address') }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Save Vendor') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Vendor Modal -->
    <div class="modal fade" id="editVendorModal" tabindex="-1" aria-labelledby="editVendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVendorModalLabel">{{ __('Edit Vendor') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editVendorForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <x-validation.error />
                        <div class="row">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_primary_contact_name" class="form__input__single__label">{{__('Primary Contact Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="primary_contact_name" id="edit_primary_contact_name" class="form-control radius-5"
                                           placeholder="{{ __('e.g. John Doe') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_company_name" class="form__input__single__label">{{__('Company Name')}}</label>
                                    <input type="text" name="company_name" id="edit_company_name" class="form-control radius-5"
                                           placeholder="{{ __('e.g. Acme Corporation') }}">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_email" class="form__input__single__label">{{__('Email Address')}}</label>
                                    <input type="email" name="email" id="edit_email" class="form-control radius-5"
                                           placeholder="{{ __('e.g. vendor@example.com') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_phone" class="form__input__single__label">{{__('Phone')}}</label>
                                    <input type="tel" name="phone" id="edit_phone" class="form-control radius-5"
                                           placeholder="{{ __('e.g. 9876543210') }}">
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_website" class="form__input__single__label">{{__('Official Website')}}</label>
                                    <input type="url" name="website" id="edit_website" class="form-control radius-5"
                                           placeholder="{{ __('e.g. https://www.example.com') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form__input__single mb-3">
                                    <label for="edit_opening_balance" class="form__input__single__label">{{__('Opening Balance')}}</label>
                                    <input type="number" step="0.01" name="opening_balance" id="edit_opening_balance" class="form-control radius-5"
                                           placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form__input__single mb-3">
                                    <label for="edit_currency" class="form__input__single__label">{{__('Currency')}}</label>
                                    <select name="currency" id="edit_currency" class="form-control radius-5">
                                        <option value="INR">INR (₹)</option>
                                        <option value="USD">USD ($)</option>
                                        <option value="EUR">EUR (€)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Addresses -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_billing_address" class="form__input__single__label">{{__('Billing Address')}}</label>
                                    <textarea name="billing_address" id="edit_billing_address" class="form-control radius-5" rows="3"
                                              placeholder="{{ __('Enter billing address') }}"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_shipping_address" class="form__input__single__label">{{__('Shipping Address')}}</label>
                                    <textarea name="shipping_address" id="edit_shipping_address" class="form-control radius-5" rows="3"
                                              placeholder="{{ __('Enter shipping address') }}"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Update Vendor') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        let selectedBranches = [];

        document.getElementById('branchDropdown').addEventListener('change', function () {
            let selectedId = this.value;
            let selectedName = this.options[this.selectedIndex].text;

            if (selectedId && !selectedBranches.find(b => b.id == selectedId)) {
                selectedBranches.push({ id: selectedId, name: selectedName });
                renderBranches();
            }

            this.value = ''; // reset dropdown
        });

        function renderBranches() {
            let container = document.getElementById('selectedBranches');
            container.innerHTML = '';
            let hiddenContainer = document.getElementById('branchHiddenInputs');
            hiddenContainer.innerHTML = '';

            selectedBranches.forEach((branch, index) => {
                let badge = document.createElement('span');
                badge.className = 'badge bg-primary m-1';
                badge.innerHTML = branch.name + 
                    ' <button type="button" class="btn-close btn-close-white btn-sm ms-2" onclick="removeBranch(' + index + ')"></button>';
                container.appendChild(badge);

                // create hidden input for form submit
                let hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'branch_id[]';
                hidden.value = branch.id;
                hiddenContainer.appendChild(hidden);
            });
        }

        function removeBranch(index) {
            selectedBranches.splice(index, 1);
            renderBranches();
        }
    </script>

    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <x-summernote.js />
    <x-media.js />
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {

                // Validate opening_balance on add
                $('#vendorForm').on('submit', function(e) {
                    const balance = parseFloat($('#opening_balance').val() || 0);
                    if (isNaN(balance)) {
                        e.preventDefault();
                        alert('{{ __("Opening balance must be a number") }}');
                        $('#opening_balance').focus();
                        return false;
                    }
                });

                // Validate opening_balance on edit
                $('#editVendorForm').on('submit', function(e) {
                    const balance = parseFloat($('#edit_opening_balance').val() || 0);
                    if (isNaN(balance)) {
                        e.preventDefault();
                        alert('{{ __("Opening balance must be a number") }}');
                        $('#edit_opening_balance').focus();
                        return false;
                    }
                });

                // Clear add form when modal is closed
                $('#addVendorModal').on('hidden.bs.modal', function () {
                    $('#vendorForm')[0].reset();
                    $('.validation-error').remove();
                });

                // Clear edit form when modal is closed
                $('#editVendorModal').on('hidden.bs.modal', function () {
                    $('#editVendorForm')[0].reset();
                    $('.validation-error').remove();
                });

                // Show modal if there are validation errors (replicates previous logic)
                @if($errors->any())
                    @if(isset($vendor) && $vendor->id)
                        $('#editVendorModal').modal('show');
                    @else
                        $('#addVendorModal').modal('show');
                    @endif
                @endif

                // Handle edit button click - populate fields & set form action
                $('.edit-vendor').on('click', function() {
                    const id = $(this).data('id');
                    const primary_contact_name = $(this).data('primary_contact_name') || '';
                    const company_name = $(this).data('company_name') || '';
                    const email = $(this).data('email') || '';
                    const phone = $(this).data('phone') || '';
                    const website = $(this).data('website') || '';
                    const opening_balance = $(this).data('opening_balance') || '0.00';
                    const currency = $(this).data('currency') || 'INR';
                    const billing_address = $(this).data('billing_address') || '';
                    const shipping_address = $(this).data('shipping_address') || '';

                    // Set form action (adjust route if your backend expects a different url)
                    $('#editVendorForm').attr('action', '/admin/vendors/update/' + id);

                    // Populate form fields
                    $('#edit_id').val(id);
                    $('#edit_primary_contact_name').val(primary_contact_name);
                    $('#edit_company_name').val(company_name);
                    $('#edit_email').val(email);
                    $('#edit_phone').val(phone);
                    $('#edit_website').val(website);
                    $('#edit_opening_balance').val(opening_balance);
                    $('#edit_currency').val(currency);
                    $('#edit_billing_address').val(billing_address);
                    $('#edit_shipping_address').val(shipping_address);
                });

                // Confirm delete forms
                $('form[action*="delete"]').on('submit', function(e) {
                    if (!confirm('{{ __("Are you sure you want to delete this vendor?") }}')) {
                        e.preventDefault();
                    }
                });

            });
        })(jQuery)
    </script>
@endsection
