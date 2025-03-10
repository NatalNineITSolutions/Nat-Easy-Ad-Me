<table class="DataTable_activation">
    <thead>
    <tr>
        @can('enquiry-form-bulk-delete')
            <th class="no-sort">
                <div class="mark-all-checkbox">
                    <input type="checkbox" class="all-checkbox">
                </div>
            </th>
        @endcan
        <th>{{__('ID')}}</th>
        <th>{{__('Name')}}</th>
        <th>{{__('Email')}}</th>
        <th>{{__('Phone')}}</th>
        <th>{{__('Message')}}</th>
        <th>{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_enquiries as $data)
        <tr>
            @can('enquiry-form-bulk-delete')
                <td> <x-bulk-action.bulk-delete-checkbox :id="$data->id"/> </td>
            @endcan
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->phone }}</td>
            <td>{{ $data->message }}</td>
            <td>
                @can('enquiry-form-delete')
                <x-popup.delete-popup :url="route('admin.enquiry.form.delete',$data->id)"/>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$all_enquiries"/>
