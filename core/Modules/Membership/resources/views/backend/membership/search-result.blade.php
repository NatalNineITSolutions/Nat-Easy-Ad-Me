<table class="dataTablesExample">
    <thead>
    <tr>
        @can('membership-bulk-delete')
            <th class="no-sort">
                <div class="mark-all-checkbox">
                    <input type="checkbox" class="all-checkbox">
                </div>
            </th>
        @endcan
        <th>{{__('ID')}}</th>
        <th>{{__('Type')}}</th>
        <th>{{__('Title')}}</th>
        <th>{{__('Price')}}</th>
        <th>{{__('Listings Limit')}}</th>
        <th>{{__('Images Limit')}}</th>
        <th>{{__('Featured listing Limit')}}</th>
        <th>{{__('Enquiry Form')}}</th>
        <th>{{__('Business Hour')}}</th>
        <th>{{__('Membership Badge')}}</th>
        <th>{{__('Status')}}</th>
        <th>{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_memberships as $subs)
        <tr>
            @can('membership-bulk-delete')
                <td> <x-bulk-action.bulk-delete-checkbox :id="$subs->id"/> </td>
            @endcan
            <td>{{ $subs->id }}</td>
            <td>{{ $subs->membership_type?->type }}</td>
            <td>{{ $subs->title }}</td>
            <td>{{ float_amount_with_currency_symbol($subs->price) }}</td>
            <td>{{ $subs->listing_limit  }}</td>
            <td>{{ $subs->gallery_images  }}</td>
            <td>{{ $subs->featured_listing  }}</td>
            <td>{{ $subs->enquiry_form == 1 ? __('Allowed') : __('Not Allowed') }}</td>
            <td>{{ $subs->business_hour == 1 ? __('Allowed') : __('Not Allowed') }}</td>
            <td>{{ $subs->membership_badge == 1 ? __('Allowed') : __('Not Allowed') }}</td>
            <td>
                <x-status.table.active-inactive :status="$subs->status"/>
            </td>
            <td>
                @can('membership-edit')
                    <a href="{{ route('admin.membership.edit',$subs->id) }}" class="cmnBtn btn_5 btn_bg_blue btnIcon radius-5"><i class="las la-pen"></i></a>
                @endcan
                @can('membership-status-change')
                    <x-status.table.status-change :url="route('admin.membership.status',$subs->id)"/>
                @endcan
                @can('membership-delete')
                    <x-popup.delete-popup :url="route('admin.membership.delete',$subs->id)"/>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$all_memberships"/>
