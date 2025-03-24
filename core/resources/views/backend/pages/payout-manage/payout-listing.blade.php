@extends('backend.admin-master')
@section('site-title')
    {{__('Payout Listing')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css />
    <x-media.css />
    <link rel="stylesheet" href="{{asset('assets/backend/css/flatpickr.min.css')}}">
    <style>
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
    </style>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-12 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Payout Listing')}}</h4>
                    </div>
                    <div class="right-content">
                        <form action="{{route('user.bv.referrals')}}" method="GET" class="date-filter-container">
                            <div class="form-group mb-0">
                                <input type="date" name="filter_date" class="form-control flatpickr-input" 
                                       value="{{ $selectedDate }}" placeholder="{{ __('Select Date') }}">
                            </div>
                            <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">
                                {{ __('Filter') }}
                            </button>
                            @if($selectedDate)
                                <a href="{{ route('user.bv.referrals') }}" class="cmnBtn reset-btn radius-5">
                                    {{ __('Reset') }}
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('S.No') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Sponsor Id') }}</th>
                                <th>{{ __('Referrals Count') }}</th>
                                <th>{{ __('BV Points') }}</th>
                                <th>{{ __('Payout Amount') }}</th>
                                <th>{{ __('Data Scope') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td>{{ $user->partner_id }}</td>
                                    <td>{{ $user->referrals_count }}</td>
                                    <td>{{ $user->bv_points }}</td>
                                    <td>{{ number_format($user->payout, 2) }}</td>
                                    <td>
                                        @if($selectedDate)
                                            {{ __('Date: ') }} {{ $selectedDate }}
                                        @else
                                            {{ __('All-time') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <x-summernote.js />
    <x-media.js />
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
        })(jQuery)
    </script>
@endsection