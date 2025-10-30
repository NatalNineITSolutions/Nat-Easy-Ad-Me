@extends('backend.admin-master')
@section('site-title')
    {{ __('Payout Listing') }}
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css />
    <x-media.css />
    <link rel="stylesheet" href="{{asset('assets/backend/css/flatpickr.min.css')}}">
    <style>
        /* keep your styles as provided */
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

        .cmnBtn[disabled] {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: #fff !important;
            cursor: not-allowed;
            opacity: 0.65;
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
                        <h4 class="header-title">{{ __('Level Based Commission Payouts') }}</h4>
                    </div>

                    <div class="text-end">
                        <strong>{{ __('Next Payout In:') }}</strong>
                        <span id="countdown-timer" class="ms-2"></span>
                    </div>

                    <div class="right-content">
                        <div class="date-filter-container">
                            <a href="{{ route('level.payouts.pdf', array_merge(request()->all(), ['export' => 'pdf'])) }}"
                                class="cmnBtn btn_5 btn_bg_blue radius-5 ms-2 mb-3">
                                {{ __('Download PDF') }}
                            </a>

                            <form action="{{ route('level.payouts.index') }}" method="GET"
                                class="d-flex align-items-center gap-2">
                                <input type="date" name="date" class="form-control flatpickr-input"
                                    value="{{ request('date') }}" placeholder="{{ __('Select Date') }}">
                                <select name="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('Pending') }}</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        {{ __('Completed') }}</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>
                                        {{ __('Failed') }}</option>
                                </select>
                                <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Filter') }}</button>
                                @if(request()->has('date') || request()->has('status'))
                                    <a href="{{ route('level.payouts.index') }}" class="cmBtn reset-btn radius-5">
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
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Total BV') }}</th>
                                <th>{{ __('TDS (%)') }}</th>
                                <th>{{ __('Service Charge (%)') }}</th>
                                <th>{{ __('Payout Amount') }}</th>
                                <th>{{ __('Payment Type') }}</th>
                                <th>{{ __('Payout Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payouts as $index => $payout)
                                <tr>
                                    {{-- Continuous numbering across pages --}}
                                    <td>{{ $payouts->firstItem() + $loop->index }}</td>

                                    {{-- Show user name if available --}}
                                    <td>{{ $payout->user->first_name ?? $payout->user->name ?? 'N/A' }}
                                        @if(isset($payout->user->last_name)) {{ ' ' . $payout->user->last_name }} @endif
                                    </td>

                                    <td>{{ ucfirst($payout->payment_type ?? 'manual') }}</td>
                                    <td>{{ number_format($payout->total_bv, 2) }}</td>
                                    <td>{{ number_format($payout->tds_percent ?? 0, 2) }}%</td>
                                    <td>{{ number_format($payout->service_charge_percent ?? 0, 2) }}%</td>
                                    <td>{{ number_format($payout->payout_amount ?? 0, 2) }}</td>
                                    <td>{{ ucfirst($payout->payment_type ?? 'manual') }}</td>

                                    <td>{{ optional($payout->payout_date)->format('d M, Y h:i A') ?? __('—') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No payouts found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        {{ $payouts->links() }}
                    </div>
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
                $(".flatpickr-input").flatpickr({ dateFormat: "Y-m-d", maxDate: "today" });

                const countdownElement = document.getElementById("countdown-timer");
                const paymentType = "{{ get_static_option('payment_type') ?? 'day' }}";
                const bvFlushTime = "{{ get_static_option('bv_flush_time') ?? '16.21' }}";

                if (countdownElement) {
                    const parseTime = (t) => {
                        const parts = t.split('.');
                        const h = parseInt(parts[0]) || 0;
                        const m = parseInt(parts[1]) || 0;
                        return { h, m };
                    };

                    const { h: payoutHour, m: payoutMinute } = parseTime(bvFlushTime);

                    const updateCountdown = () => {
                        const now = new Date();
                        let nextPayout = new Date();
                        nextPayout.setHours(payoutHour, payoutMinute, 0, 0);

                        if (now >= nextPayout) {
                            switch (paymentType) {
                                case 'week': nextPayout.setDate(nextPayout.getDate() + 7); break;
                                case 'month': nextPayout.setMonth(nextPayout.getMonth() + 1); break;
                                default: nextPayout.setDate(nextPayout.getDate() + 1);
                            }
                        }

                        const diff = nextPayout - now;
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        let parts = [];
                        if (days > 0) parts.push(days + 'd');
                        if (hours > 0 || days > 0) parts.push(hours + 'h');
                        if (minutes > 0 || hours > 0 || days > 0) parts.push(minutes + 'm');
                        parts.push(seconds + 's');

                        countdownElement.textContent = parts.join(' ');
                        setTimeout(updateCountdown, 1000);
                    };

                    updateCountdown();
                }

                $('#payoutButton').on('click', function () {
                    const now = new Date();
                    const parseTime = (t) => {
                        const parts = t.split('.');
                        const h = parseInt(parts[0]) || 0;
                        const m = parseInt(parts[1]) || 0;
                        return { h, m };
                    };
                    const { h: payoutHour, m: payoutMinute } = parseTime(bvFlushTime);

                    let payoutTime = new Date();
                    payoutTime.setHours(payoutHour, payoutMinute, 0, 0);

                    if (now >= payoutTime) {
                        Swal.fire({
                            title: '{{ __("Process Payout?") }}',
                            text: '{{ __("The payout time has been reached. Do you want to proceed with the payout?") }}',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '{{ __("Yes, process payout!") }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#payoutForm').submit();
                            }
                        });
                    } else {
                        const diff = payoutTime - now;
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        Swal.fire({
                            title: '{{ __("Payout Not Available Yet") }}',
                            html: `{{ __("Next payout will be available in") }} <strong>${days}d ${hours}h ${minutes}m ${seconds}s</strong>`,
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