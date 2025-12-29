<table class="DataTable_activation">
    <thead>
    <tr>
        @can('district-bulk-delete')
            <th class="no-sort">
                <div class="mark-all-checkbox">
                    <input type="checkbox" class="all-checkbox">
                </div>
            </th>
        @endcan

        <th>{{ __('ID') }}</th>
        <th>{{ __('District') }}</th>
        <th>{{ __('State') }}</th>
        <th>{{ __('Country') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
    </thead>

    <tbody>
    @foreach($all_districts as $district)
        <tr>
            @can('district-bulk-delete')
                <td>
                    <x-bulk-action.bulk-delete-checkbox :id="$district->id"/>
                </td>
            @endcan

            <td>{{ $district->id }}</td>
            <td>{{ $district->district }}</td>
            <td>{{ optional($district->state)->state }}</td>
            <td>{{ optional($district->country)->country }}</td>
            <td>
                <x-status.table.active-inactive :status="$district->status"/>
            </td>

            <td>
                @can('district-edit')
                    <a
                        class="cmnBtn btn_5 btn_bg_warning radius-5 edit_district_modal"
                        data-bs-toggle="modal"
                        data-bs-target="#editDistrictModal"
                        data-district_id="{{ $district->id }}"
                        data-district="{{ $district->district }}"
                        data-country="{{ $district->country_id }}"
                        data-state="{{ $district->state_id }}">
                        {{ __('Edit District') }}
                    </a>
                @endcan

                @can('district-delete')
                    <x-popup.delete-popup
                        :title="__('Delete District')"
                        :url="route('admin.district.delete', $district->id)"/>
                @endcan

                @can('district-status-change')
                    <x-status.table.status-change
                        :title="__('Change Status')"
                        :url="route('admin.district.status', $district->id)"/>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<x-pagination.laravel-paginate :allData="$all_districts"/>
