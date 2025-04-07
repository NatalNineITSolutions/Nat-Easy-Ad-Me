@extends('frontend.layout.master')
@section('title', __('Job Seeker Profile'))

@section('style')
    <x-media.css />
    <style>
        .new_image_add_listing .attachment-preview {
            width: 200px;
            height: 200px;
            border-radius: 6px;
            overflow: hidden;
        }

        .new_image_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
        }

        button.btn.btn-info.media_upload_form_btn {
            background-color: rgb(239, 246, 255);
            border: none;
            color: rgb(59, 130, 246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Create Your Job Seeker Profile</h1>

        <form method="POST" action="{{ route('user.addjob.listing') }}" enctype="multipart/form-data">
            @csrf

            <!-- Personal Information Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Personal Information</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Address *</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Profile Picture</label>
                            <div class="media-upload-btn-wrapper">
                                <!-- <div class="img-wrap new_image_add_listing">
                                                    <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                                </div> -->
                                <input type="hidden" name="image">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                    data-btntitle="{{__('Select Image')}}" data-modaltitle="{{__('Upload Image')}}"
                                    data-bs-toggle="modal" data-bs-target="#media_upload_modal">
                                    {{ __('Upload Profile Picture') }}
                                </button>
                                <small>{{ __('image format: jpg,jpeg,png,gif,webp')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Category Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Job Preferences</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <input type="hidden" name="sub_category_id" value="107">
                        <div class="col-md-12">
                            <label class="form-label">Job Type *</label>
                            <select name="child_category_id" id="child_category_id" class="form-select" required>
                                <option value="">Select Job Type</option>
                                @if(isset($specific_subcategory) && $specific_subcategory->childcategories->isNotEmpty())
                                    @foreach($specific_subcategory->childcategories as $childcategory)
                                        <option value="{{ $childcategory->id }}">{{ $childcategory->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resume/CV Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Resume Information</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Work Experience *</label>
                        <input type="text" name="work_experience" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Education *</label>
                        <input type="text" name="education" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills * (comma separated)</label>
                        <input type="text" name="skills" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Certifications</label>
                            <input type="text" name="certifications" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Achievements</label>
                            <input type="text" name="achievements" class="form-control">
                        </div>
                    </div>

                    <!-- Only Project as textarea -->
                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <textarea name="projects" class="form-control" rows="4"></textarea>
                    </div>

                    <!-- Only Summary as textarea -->
                    <div class="mb-3">
                        <label class="form-label">Professional Summary *</label>
                        <textarea name="summary" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Portfolio Links (GitHub, LinkedIn, etc.)</label>
                        <input type="text" name="portfolio_links" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Application Details Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Application Details</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Available From *</label>
                            <input type="date" name="availability_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Work Preference *</label>
                            <select name="work_preference" class="form-select" required>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="onsite">On-site</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expected Salary *</label>
                            <input type="number" name="expected_salary" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Willing to Relocate? *</label>
                            <select name="relocation_willingness" class="form-select" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Work Authorization/Visa Status *</label>
                            <input type="text" name="work_authorization" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Submit Profile</button>
            </div>
        </form>
    </div>

    <x-media.markup type="web" />
@endsection

@section('scripts')
    <x-media.js type="web" />
    <script>
        // Initialize media uploader for profile picture
        $(document).ready(function () {
            // This will be handled by the media uploader component
        });
    </script>

    <script>
        $(document).ready(function () {
            // Handle category change to load subcategories
            $('#category_id').change(function () {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.subcategories') }}",
                        type: "GET",
                        data: { category_id: categoryId },
                        success: function (data) {
                            $('#sub_category_id').empty();
                            $('#sub_category_id').append('<option value="">Select Subcategory</option>');
                            $.each(data, function (key, value) {
                                $('#sub_category_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            // Reset child category when category changes
                            $('#child_category_id').empty();
                            $('#child_category_id').append('<option value="">Select Child Category</option>');
                        }
                    });
                } else {
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append('<option value="">Select Subcategory</option>');
                    $('#child_category_id').empty();
                    $('#child_category_id').append('<option value="">Select Child Category</option>');
                }
            });

            // Handle subcategory change to load child categories
            $('#sub_category_id').change(function () {
                var subcategoryId = $(this).val();
                if (subcategoryId) {
                    $.ajax({
                        url: "{{ route('get.childcategories') }}",
                        type: "GET",
                        data: { sub_category_id: subcategoryId },
                        success: function (data) {
                            $('#child_category_id').empty();
                            $('#child_category_id').append('<option value="">Select Child Category</option>');
                            $.each(data, function (key, value) {
                                $('#child_category_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#child_category_id').empty();
                    $('#child_category_id').append('<option value="">Select Child Category</option>');
                }
            });
        });
    </script>
@endsection