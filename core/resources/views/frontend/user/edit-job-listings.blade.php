@extends('frontend.layout.master')
@section('title', __('Edit Job Seeker Profile'))

@section('style')
    <x-media.css />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        /* Style for date input to match other fields */
        input[type="date"].form-control {
            height: 45px;
            padding: 10px 15px;
            font-size: 14px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input[type="date"].form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .card-header {
            border-radius: 8px 8px 0 0 !important;
            padding: 15px 20px;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            padding: 10px 30px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 45px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }

        /* Profile background styles */
        .profile-setting {
            padding-top: 30px;
        }

        .profile-setting-wraper {
            background-color: #f8f9fa;
        }

        .box-shadow1 {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .red-btn {
            background: #3b82f6;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
        }

        .red-btn:hover {
            background: #2563eb;
            color: white;
        }

        .head4 {
            color: #1a1a1a;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="head4">{{ __('Edit Job Listing') }}</h3>
            <a href="{{ route('user.job.listings') }}" class="red-btn">
                <i class="las la-arrow-left"></i> {{ __('Back to Listings') }}
            </a>
        </div>

        <form method="POST" action="{{ route('user.update.job', $jobDetail->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Personal Information</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control"
                                value="{{ old('full_name', $jobDetail->full_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $jobDetail->email) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control"
                                value="{{ old('phone', $jobDetail->phone) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $jobDetail->dob) }}"
                                max="{{ date('Y-m-d', strtotime('-18 years')) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Current Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="3"
                                required>{{ old('address', $jobDetail->address) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Profile Picture <span class="text-danger">*</span></label>
                            <div class="media-upload-btn-wrapper">
                                <input type="hidden" name="image" value="{{ old('image', $jobDetail->image) }}">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                    data-btntitle="{{ __('Select Image') }}" data-modaltitle="{{ __('Upload Image') }}"
                                    data-bs-toggle="modal" data-bs-target="#media_upload_modal">
                                    {{ __('Upload Profile Picture') }}
                                </button>
                                <small>{{ __('image format: jpg, jpeg, png, gif, webp') }}</small>
                            </div>
                            @if($jobDetail->image)
                                <div class="mt-2">
                                    <img src="{{ get_attachment_image_by_id($jobDetail->image)['img_url'] ?? '' }}"
                                        alt="Profile Picture" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Location Information</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select name="country_id" id="country_id" class="form-control select2" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id', $jobDetail->country_id) == $country->id ? 'selected' : '' }}>{{ $country->country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <select name="state_id" id="state_id" class="form-control select2" required>
                                <option value="">Select State</option>
                                @foreach($all_states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id', $jobDetail->state_id) == $state->id ? 'selected' : '' }}>{{ $state->state }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <select name="city_id" id="city_id" class="form-control select2" required>
                                <option value="">Select City</option>
                                @foreach($all_cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $jobDetail->city_id) == $city->id ? 'selected' : '' }}>{{ $city->city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Preferences Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Job Preferences</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <input type="hidden" name="sub_category_id" value="107">
                        <div class="col-md-12">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <select name="child_category_id" id="child_category_id" class="form-control select2" required>
                                <option value="">Select Job Type</option>
                                @if(isset($specific_subcategory) && $specific_subcategory->childcategories->isNotEmpty())
                                    @foreach($specific_subcategory->childcategories as $childcategory)
                                        <option value="{{ $childcategory->id }}" {{ old('child_category_id', $jobDetail->child_category_id) == $childcategory->id ? 'selected' : '' }}>
                                            {{ $childcategory->name }}
                                        </option>
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
                        <label class="form-label">Work Experience <span class="text-danger">*</span></label>
                        <input type="text" name="work_experience" class="form-control"
                            value="{{ old('work_experience', $jobDetail->work_experience) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Education <span class="text-danger">*</span></label>
                        <input type="text" name="education" class="form-control"
                            value="{{ old('education', $jobDetail->education) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills <span class="text-danger">*</span></label>
                        <input type="text" name="skills" class="form-control"
                            value="{{ old('skills', $jobDetail->skills) }}" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Certifications</label>
                            <input type="text" name="certifications" class="form-control"
                                value="{{ old('certifications', $jobDetail->certifications) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Achievements</label>
                            <input type="text" name="achievements" class="form-control"
                                value="{{ old('achievements', $jobDetail->achievements) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <textarea name="projects" class="form-control"
                            rows="3">{{ old('projects', $jobDetail->projects) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Professional Summary <span class="text-danger">*</span></label>
                        <textarea name="summary" class="form-control" rows="3"
                            required>{{ old('summary', $jobDetail->summary) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Portfolio Links (GitHub, LinkedIn, etc.)</label>
                        <input type="text" name="portfolio_links" class="form-control"
                            value="{{ old('portfolio_links', $jobDetail->portfolio_links) }}">
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
                            <label class="form-label">Available From <span class="text-danger">*</span></label>
                            <input type="date" name="availability_date" class="form-control"
                                value="{{ old('availability_date', $jobDetail->availability_date) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Work Preference <span class="text-danger">*</span></label>
                            <select name="work_preference" class="form-control select2" required>
                                <option value="remote" {{ old('work_preference', $jobDetail->work_preference) == 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="hybrid" {{ old('work_preference', $jobDetail->work_preference) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="onsite" {{ old('work_preference', $jobDetail->work_preference) == 'onsite' ? 'selected' : '' }}>On-site</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expected Salary <span class="text-danger">*</span></label>
                            <input type="number" name="expected_salary" class="form-control"
                                value="{{ old('expected_salary', $jobDetail->expected_salary) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Willing to Relocate? <span class="text-danger">*</span></label>
                            <select name="relocation_willingness" class="form-control select2" required>
                                <option value="1" {{ old('relocation_willingness', $jobDetail->relocation_willingness) == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('relocation_willingness', $jobDetail->relocation_willingness) == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Work Authorization/Visa Status <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="work_authorization" class="form-control"
                                value="{{ old('work_authorization', $jobDetail->work_authorization) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <x-media.markup type="web" />
@endsection

@section('scripts')
    <x-media.js type="web" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Initialize media uploader for profile picture
            $(document).on('click', '.media_upload_form_btn', function (e) {
                e.preventDefault();
                var form = $(this).closest('.media-upload-btn-wrapper');
                var modal = $('#media_upload_modal');
                modal.find('.modal-title').text($(this).data('modaltitle'));
                modal.find('.btn-title').text($(this).data('btntitle'));
                modal.modal('show');
            });
        });
    </script>
@endsection