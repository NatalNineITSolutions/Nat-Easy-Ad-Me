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

        #countdown-timer {
            font-size: 1.1rem;
            color: #dc3545;
            font-weight: bold;
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
                        $bvFlushTime = get_static_option('bv_flush_time') ?? '16.21';
                        $paymentType = get_static_option('payment_type') ?? 'day';
                    @endphp

                    <div class="text-end">
                        <strong>{{ __('Next Payout In:') }}</strong>
                        <span id="countdown-timer" class="ms-2"></span>
                    </div>

                    <div class="right-content">
                        <div class="date-filter-container">
                            {{-- Payout Button --}}
                            <form id="payoutForm" action="{{ route('user.payout.process') }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @foreach($users as $user)
                                    @if($user->payoutDetail && $user->payoutDetail->status == 'payout_eligible')
                                        <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                        <input type="hidden" name="payout_detail_id[]" value="{{ $user->payoutDetail->id }}">
                                    @endif
                                @endforeach
                                <button type="button" id="payoutButton" class="cmnBtn btn_5 btn_bg_blue radius-5">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                // Initialize date picker
                $(".flatpickr-input").flatpickr({
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });

                // Countdown timer
                const countdownElement = document.getElementById("countdown-timer");
                const paymentType = "{{ get_static_option('payment_type') ?? 'day' }}";
                const bvFlushTime = "{{ get_static_option('bv_flush_time') ?? '16.21' }}";

                if (countdownElement) {
                    // Parse payout time (e.g., "16.21" → 16:21)
                    const [hoursStr, minutesStr] = bvFlushTime.split('.');
                    const payoutHour = parseInt(hoursStr) || 16;
                    const payoutMinute = parseInt(minutesStr) || 0;

                    const updateCountdown = () => {
                        const now = new Date();
                        let nextPayout = new Date();

                        // Set the payout time for today
                        nextPayout.setHours(payoutHour, payoutMinute, 0, 0);

                        // If payout time has passed today, calculate next payout based on payment type
                        if (now >= nextPayout) {
                            switch (paymentType) {
                                case 'day':
                                    nextPayout.setDate(nextPayout.getDate() + 1);
                                    break;
                                case 'week':
                                    nextPayout.setDate(nextPayout.getDate() + 7);
                                    break;
                                case 'month':
                                    nextPayout.setMonth(nextPayout.getMonth() + 1);
                                    // Handle cases where next month doesn't have this day (e.g., Jan 31 → Feb 28/29)
                                    if (nextPayout.getDate() < now.getDate()) {
                                        nextPayout.setDate(0); // Last day of previous month
                                    }
                                    break;
                                default:
                                    nextPayout.setDate(nextPayout.getDate() + 1);
                            }
                        }

                        const diff = nextPayout - now;
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        let parts = [];
                        if (days > 0) parts.push(`${days}d`);
                        if (hours > 0 || days > 0) parts.push(`${hours}h`);
                        if (minutes > 0 || hours > 0 || days > 0) parts.push(`${minutes}m`);
                        parts.push(`${seconds}s`);

                        countdownElement.textContent = parts.join(' ');

                        // Update every second
                        setTimeout(updateCountdown, 1000);
                    };

                    // Initial call
                    updateCountdown();
                }

                // Payout button click handler with proper time validation
                $('#payoutButton').on('click', function () {
                    const now = new Date();
                    const payoutTime = new Date();
                    const bvFlushTime = "{{ get_static_option('bv_flush_time') ?? '16.21' }}";
                    const paymentType = "{{ get_static_option('payment_type') ?? 'day' }}";

                    // Parse payout time (e.g., "16.21" → 16:21)
                    const [hoursStr, minutesStr] = bvFlushTime.split('.');
                    const payoutHour = parseInt(hoursStr) || 16;
                    const payoutMinute = parseInt(minutesStr) || 0;

                    // Set payout time for today
                    payoutTime.setHours(payoutHour, payoutMinute, 0, 0);

                    // Calculate next valid payout time
                    if (now >= payoutTime) {
                        switch (paymentType) {
                            case 'day':
                                payoutTime.setDate(payoutTime.getDate() + 1);
                                break;
                            case 'week':
                                payoutTime.setDate(payoutTime.getDate() + 7);
                                break;
                            case 'month':
                                const payoutDay = payoutTime.getDate();
                                payoutTime.setMonth(payoutTime.getMonth() + 1);
                                const daysInNextMonth = new Date(
                                    payoutTime.getFullYear(),
                                    payoutTime.getMonth() + 1,
                                    0
                                ).getDate();
                                payoutTime.setDate(Math.min(payoutDay, daysInNextMonth));
                                break;
                        }
                    }

                    // Only show payout dialog if current time is exactly at or after payout time
                    if (now >= payoutTime) {
                        Swal.fire({
                            title: '{{ __("Process Payout?") }}',
                            text: '{{ __("The payout time has been reached. Do you want to proceed with the payout?") }}',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '{{ __("Yes, process payout!") }}',
                            cancelButtonText: '{{ __("Cancel") }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#payoutForm').submit();
                            }
                        });
                    } else {
                        // Calculate remaining time
                        const diff = payoutTime - now;
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        Swal.fire({
                            title: '{{ __("Payout Not Available Yet") }}',
                            html: `{{ __("The payout time has not been reached yet.") }}<br><br>
                      {{ __("Next payout will be available in") }} <strong>
                      ${days}d ${hours}h ${minutes}m ${seconds}s</strong>`,
                            icon: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: '{{ __("OK") }}'
                        });
                    }
                });
            });
        })(jQuery);
    </script>
@endsection