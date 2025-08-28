@extends('backend.admin-master')
@section('site-title')
    {{__('Branches Management')}}
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
                        <h4 class="header-title">{{__('Branches Management')}}</h4>
                    </div>
                    <div class="right-content">
                        <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                            <i class="fas fa-plus me-2"></i> {{ __('Add New Branch') }}
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
                
                <!-- Branches List -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->email }}</td>
                                    <td>{{ $branch->phone_number }}</td>
                                    <td>{{ Str::limit($branch->branch_location, 50) }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-primary btn-sm edit-branch" 
                                                data-bs-toggle="modal" data-bs-target="#editBranchModal"
                                                data-id="{{ $branch->id }}"
                                                data-name="{{ $branch->name }}"
                                                data-email="{{ $branch->email }}"
                                                data-phone_number="{{ $branch->phone_number }}"
                                                data-branch_location="{{ $branch->branch_location }}">
                                                {{ __('Edit') }}
                                            </button>
                                            <form action="{{ route('admin.branches.delete', $branch->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this branch?')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No branches found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Check if branches is a LengthAwarePaginator instance before calling hasPages() --}}
                @if(method_exists($branches, 'hasPages') && $branches->hasPages())
                    <div class="mt-3">
                        {{ $branches->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Branch Modal -->
    <div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBranchModalLabel">{{ __('Add New Branch') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.branches.store')}}" method="POST" id="branchForm">
                    @csrf
                    <div class="modal-body">
                        <x-validation.error />
                        <div class="row">
                            <!-- First Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="name" class="form__input__single__label">{{__('Branch Name')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control radius-5"
                                        value="{{ old('name') }}" placeholder="{{ __('Enter branch name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="email" class="form__input__single__label">{{__('Email Address')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control radius-5"
                                        value="{{ old('email') }}" placeholder="{{ __('Enter email address') }}" required>
                                </div>
                            </div>

                            <!-- Second Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="phone_number" class="form__input__single__label">{{__('Phone Number')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" name="phone_number" id="phone_number" class="form-control radius-5"
                                        value="{{ old('phone_number') }}" placeholder="{{ __('Enter phone number') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="password" class="form__input__single__label">{{__('Password')}}
                                        <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control radius-5"
                                        placeholder="{{ __('Enter password') }}" required>
                                </div>
                            </div>

                            <!-- Third Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="password_confirmation"
                                        class="form__input__single__label">{{__('Confirm Password')}}<span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control radius-5" placeholder="{{ __('Confirm password') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="branch_location"
                                        class="form__input__single__label">{{__('Branch Location')}}<span
                                            class="text-danger">*</span></label>
                                    <textarea name="branch_location" id="branch_location" class="form-control radius-5" rows="2"
                                        placeholder="{{ __('Enter branch location') }}" required>{{ old('branch_location') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Save Branch') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Branch Modal -->
    <div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchModalLabel">{{ __('Edit Branch') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editBranchForm">
                    @csrf
                    <div class="modal-body">
                        <x-validation.error />
                        <input type="hidden" name="id" id="edit_id">
                        <div class="row">
                            <!-- First Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_name" class="form__input__single__label">{{__('Branch Name')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="edit_name" class="form-control radius-5"
                                        placeholder="{{ __('Enter branch name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_email" class="form__input__single__label">{{__('Email Address')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="edit_email" class="form-control radius-5"
                                        placeholder="{{ __('Enter email address') }}" required>
                                </div>
                            </div>

                            <!-- Second Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_phone_number" class="form__input__single__label">{{__('Phone Number')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" name="phone_number" id="edit_phone_number" class="form-control radius-5"
                                        placeholder="{{ __('Enter phone number') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_password" class="form__input__single__label">{{__('Password')}}
                                        <span class="text-muted">({{ __('Leave blank to keep current password') }})</span></label>
                                    <input type="password" name="password" id="edit_password" class="form-control radius-5"
                                        placeholder="{{ __('Enter new password') }}">
                                </div>
                            </div>

                            <!-- Third Row -->
                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_password_confirmation"
                                        class="form__input__single__label">{{__('Confirm Password')}}</label>
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                        class="form-control radius-5" placeholder="{{ __('Confirm new password') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form__input__single mb-3">
                                    <label for="edit_branch_location"
                                        class="form__input__single__label">{{__('Branch Location')}}<span
                                            class="text-danger">*</span></label>
                                    <textarea name="branch_location" id="edit_branch_location" class="form-control radius-5" rows="2"
                                        placeholder="{{ __('Enter branch location') }}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Update Branch') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <x-summernote.js />
    <x-media.js />
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                // Password confirmation validation for add form
                $('#branchForm').on('submit', function(e) {
                    const password = $('#password').val();
                    const passwordConfirmation = $('#password_confirmation').val();
                    
                    if (password !== passwordConfirmation) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        $('#password_confirmation').focus();
                    }
                });

                // Password confirmation validation for edit form
                $('#editBranchForm').on('submit', function(e) {
                    const password = $('#edit_password').val();
                    const passwordConfirmation = $('#edit_password_confirmation').val();
                    
                    if (password !== passwordConfirmation) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        $('#edit_password_confirmation').focus();
                    }
                });

                // Clear form when modal is closed
                $('#addBranchModal').on('hidden.bs.modal', function () {
                    $('#branchForm')[0].reset();
                    $('.validation-error').remove();
                });

                // Clear form when edit modal is closed
                $('#editBranchModal').on('hidden.bs.modal', function () {
                    $('#editBranchForm')[0].reset();
                    $('.validation-error').remove();
                });

                // Show modal if there are validation errors
                @if($errors->any())
                    @if(isset($branch) && $branch->id)
                        $('#editBranchModal').modal('show');
                    @else
                        $('#addBranchModal').modal('show');
                    @endif
                @endif
                
                // Handle edit button click
                $('.edit-branch').on('click', function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    const email = $(this).data('email');
                    const phone_number = $(this).data('phone_number');
                    const branch_location = $(this).data('branch_location');
                    
                    // Set form action
                    $('#editBranchForm').attr('action', '/admin/branches/update/' + id);
                    
                    // Populate form fields
                    $('#edit_id').val(id);
                    $('#edit_name').val(name);
                    $('#edit_email').val(email);
                    $('#edit_phone_number').val(phone_number);
                    $('#edit_branch_location').val(branch_location);
                    
                    // Clear password fields
                    $('#edit_password').val('');
                    $('#edit_password_confirmation').val('');
                });

                // Handle delete form submission
                $('form[action*="delete"]').on('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this branch?')) {
                        this.submit();
                    }
                });
            });
        })(jQuery)
    </script>
@endsection