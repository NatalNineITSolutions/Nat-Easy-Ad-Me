@extends('frontend.layout.master')
@section('site-title')
    {{__('Job Listings')}}
@endsection
@section('style')
    <x-media.css />
    <style>
        .img-wrap {
            width: 111px;
        }

        .input-form {
            position: relative;
        }

        .id-upload-btn {
            cursor: pointer;
            border: 1px solid #ccc;
            padding: 8px 12px;
            display: inline-block;
        }

        .id-upload-btn i {
            margin-right: 5px;
        }

        .file-name {
            display: inline-block;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        label.d-block.file-name {
            max-width: fit-content !important;
        }

        .single-input {
            display: grid;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .badge-active {
            background-color: #22C55E;
            color: white;
        }

        .badge-inactive {
            background-color: #6B7280;
            color: white;
        }

        .action-btns {
            display: flex;
            gap: 5px;
        }

        /* New styles to match the Payout Listing table */
        .date-filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reset-btn {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="profile-setting setting-page verify-identity section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')
                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')
                            <div class="main-body">
                                <x-frontend.user.responsive-icon />
                                <div class="setting-btn-part">
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="tab-content-wraper box-shadow1">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h3 class="head4">{{ __('All Job Listings') }}</h3>
                                                    <a href="{{ route('user.addjob.listing') }}" class="red-btn">
                                                        <i class="las la-plus"></i> {{ __('Add New Job') }}
                                                    </a>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>{{ __('Name') }}</th>
                                                                <th>{{ __('Email') }}</th>
                                                                <th>{{ __('Education') }}</th>
                                                                <!-- <th>{{ __('Posted') }}</th> -->
                                                                <th>{{ __('Actions') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($jobs as $index => $job)
                                                                <tr>
                                                                    <td>{{ $jobs->firstItem() + $index }}</td>
                                                                    <td>{{ $job->full_name }}</td>
                                                                    <td>{{ $job->email }}</td>
                                                                    <td>{{ $job->education }}</td>
                                                                    <!-- <td>{{ $job->created_at->diffForHumans() }}</td> -->
                                                                    <td>
                                                                        <div class="action-btns">
                                                                            <a href="{{ route('user.edit.job', $job->id) }}"
                                                                                class="btn btn-primary btn-sm" title="Edit">
                                                                                <i class="las la-edit"></i>
                                                                            </a>
                                                                            
                                                                            <form action="{{ route('user.delete.job', $job->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to delete this job?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    title="Delete">
                                                                                    <i class="las la-trash"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">
                                                                        {{ __('No job listings found.') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="save-change-btn mt-4">
                                                    {{ $jobs->links() }}
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
    </div>
    <x-media.markup :type="'web'" />
@endsection

@section('scripts')
    <x-media.js :type="'web'" />
    <script src="{{asset('assets/backend/js/flatpickr.min.js')}}"></script>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                // Initialize date picker
                $(".flatpickr-input").flatpickr({
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });
            });
        })(jQuery);
    </script>
@endsection