<table class="table">
    <thead class="table-head-light">
    <tr>
        <th>{{ __('Plan') }}</th>
        <th>{{ __('Amount') }}</th>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Payment Method') }}</th>
        <th>{{ __('Payment Status') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_memberships as $membership)
        <tr>
            <td>{{ $membership->membership?->membership_type?->type }}</td>
            <td>{{ float_amount_with_currency_symbol($membership->price) }}</td>
            <td>{{ $membership->created_at->format('Y-m-d') ?? '' }}</td>
            <td>
                @if($membership->payment_gateway == 'manual_payment')
                    {{ ucfirst(str_replace('_',' ',$membership->payment_gateway)) }}
                @else
                    {{ $membership->payment_gateway == 'authorize_dot_net' ? __('Authorize.Net') : ucfirst($membership->payment_gateway) }}
                @endif
            </td>
            <td>
                @if($membership->payment_status == '' || $membership->payment_status == 'cancel')
                    <span class="status cancel-status">{{ __('Cancel') }}</span>
                @elseif($membership->payment_status == 'pending')
                    <span class="status pending-status">{{ __('Pending') }}</span>
                @else
                    <span class="status accepted-status">{{ ucfirst($membership->payment_status) }}</span>
                @endif

               <!-- membership payment history modal button -->
                <a class="cmnBtn btn_5 btn_bg_warning radius-5 show_membership_payment_history_modal"
                   data-bs-toggle="modal"
                   data-bs-target="#user_membership_payment_history_modal"
                   data-membership_history_id="{{ $membership->id }}"
                   data-membership_type="{{ $membership->membership?->membership_type?->type }}"
                   data-membership_purchase_date_history="{{ $membership->created_at->format('Y-m-d') ?? '' }}"
                   data-membership_expire_date_history="{{ Carbon\Carbon::parse($membership->expire_date)->format('Y-m-d') }}"

                   data-listing_limit="{{ $membership->listing_limit }}"
                   data-gallery_images="{{ $membership->gallery_images }}"
                   data-featured_listing="{{ $membership->featured_listing }}"
                   data-business_hour="{{ $membership->business_hour }}"
                   data-enquiry_form="{{ $membership->enquiry_form }}"
                   data-membership_badge="{{ $membership->membership_badge }}"
                >
                    <i class="fa-solid fa-angle-right ms-3"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="deposit-history-pagination mt-4">
    <x-pagination.laravel-paginate :allData="$all_memberships"/>
</div>
