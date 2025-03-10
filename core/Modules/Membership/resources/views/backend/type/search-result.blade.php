<table class="DataTable_activation">
    <thead>
    <tr>
        @can('membership-type-bulk-delete')
            <th class="no-sort">
                <div class="mark-all-checkbox">
                    <input type="checkbox" class="all-checkbox">
                </div>
            </th>
        @endcan
        <th>{{__('ID')}}</th>
        <th>{{__('Type')}}</th>
        <th>{{__('Validity')}}</th>
        <th>{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_types as $type)
        <tr>
            @can('membership-type-bulk-delete')
                <td> <x-bulk-action.bulk-delete-checkbox :id="$type->id"/> </td>
            @endcan
            <td>{{ $type->id }}</td>
            <td>{{ $type->type }}</td>
            <td>{{ $type->validity }} {{ __('days') }}</td>
            <td>
                    @can('membership-type-edit')
                        <a class="cmnBtn btn_5 btn_bg_warning btnIcon radius-5 edit_type_modal"
                            data-bs-toggle="modal"
                            data-bs-target="#editTypeModal"
                            data-id="{{ $type->id }}"
                            data-type="{{ $type->type }}"
                            data-validity="{{ $type->validity }}">
                           <i class="las la-pen"></i>
                        </a>
                    @endcan
                    @can('membership-type-delete')
                        <x-popup.delete-popup :url="route('admin.membership.type.delete',$type->id)"/>
                    @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$all_types"/>
