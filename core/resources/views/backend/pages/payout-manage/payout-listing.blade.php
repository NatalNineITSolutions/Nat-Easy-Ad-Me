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

        .bg-blue {
            background-color: #007bff !important;
        }

        .cmnBtn[disabled] {
            background-color: #6c757d !important;
            /* a medium grey */
            border-color: #6c757d !important;
            color: #ffffff !important;
            cursor: not-allowed;
            opacity: 0.65;
        }

        .cmnBtn[disabled]:hover {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            box-shadow: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-12 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{ __('Payout Listing') }}</h4>
                    </div>
                    @php
                        use Carbon\Carbon;

                        $bvFlushTime = get_static_option('bv_flush_time') ?? '16.21';
                        $paymentType = get_static_option('payment_type') ?? 'day';

                        // parse “16.21” → [16,21]
                        [$hour, $minute] = array_pad(explode('.', $bvFlushTime), 2, 0);
                        $hour = (int) $hour;
                        $minute = (int) $minute;

                        // **dynamically** convert the passed timestamp
                        $lastPayout = Carbon::parse($lastPayoutAt)
                            ->setTime($hour, $minute);

                        // compute next
                        $nextPayout = $lastPayout->copy();
                        if ($paymentType === 'day') {
                            $nextPayout->addDay();
                        } elseif ($paymentType === 'week') {
                            $nextPayout->addWeek();
                        } elseif ($paymentType === 'month') {
                            $nextPayout->addDays(28);
                        }

                        $now = Carbon::now();
                        $remainingSeconds = $now->diffInSeconds($nextPayout, false);
                        $payoutAllowed = $remainingSeconds <= 0;
                    @endphp


                    @if($remainingSeconds > 0)
                        <div class="text-end">
                            <strong>{{ __('Next Payout In:') }}</strong>
                            <span id="countdown-timer" class="text-danger fw-bold"></span>
                        </div>
                    @endif

                    <div class="right-content">
                        <div class="date-filter-container">
                            {{-- Payout Button --}}
                            <form action="{{ route('user.payout.process') }}" method="POST" class="d-inline-block">
                                @csrf
                                @foreach($users as $user)
                                    <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                    <input type="hidden" name="payout_detail_id[]" value="{{ $user->payout_details->id }}">
                                @endforeach
                                <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5" @if(!$payoutAllowed || (isset($user->payoutDetail) && $user->payoutDetail->status == 'processed')) disabled
                                @endif>
                                    {{ __('Payout') }}
                                </button>
                            </form>

                            {{-- Date Filter Form --}}
                            <form action="{{ route('user.bv.referrals') }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                <input type="date" name="filter_date" class="form-control flatpickr-input"
                                    value="{{ $selectedDate }}" placeholder="{{ __('Select Date') }}">
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
                                    <td>{{ $user->total_referrals }}</td>
                                    <td>{{ $user->bv_points }}</td>
                                    <td>{{ number_format($user->net_amount, 2) }}</td>
                                    <td>
                                        @if($selectedDate)
                                            {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                                        @elseif($user->payout_date)
                                            {{ \Carbon\Carbon::parse($user->payout_date)->format('d M Y') }}
                                        @else
                                            {{ __('All-time') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3 text-end" role="alert">
                    <strong>{{ __('Balance Case on Hand:') }}</strong> {{ number_format($cashOnHand, 2) }}
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
@section('scripts')
    <!-- … other scripts … -->

    <script>
            (function ($) {
                "use strict";

                $(document).ready(function () {
                    const countdownElement = document.getElementById("countdown-timer");
                    let seconds = {{ $remainingSeconds }};

                    if (countdownElement && seconds > 0) {
                        const timer = setInterval(() => {
                            if (seconds <= 0) {
                                countdownElement.textContent = "{{ __('Processing...') }}";
                                clearInterval(timer);
                                return;
                            }

                            const days = Math.floor(seconds / (3600 * 24));
                            const hours = Math.floor((seconds % (3600 * 24)) / 3600);
                            const minutes = Math.floor((seconds % 3600) / 60);
                            const secs = seconds % 60;

                            let parts = [];
                            if (days > 0) parts.push(`${days}d`);
                            if (hours > 0 || days > 0) parts.push(`${hours}h`);
                            parts.push(`${minutes}m`);
                            parts.push(`${secs}s`);

                            countdownElement.textContent = parts.join(' ');
                            seconds--;
                        }, 1000);
                    }
                });
            })(jQuery);
    </script>
@endsection