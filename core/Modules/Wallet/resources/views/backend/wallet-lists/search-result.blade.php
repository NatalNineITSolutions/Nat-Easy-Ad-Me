<table class="DataTable_activation">
    <thead>
    <tr>
        <th>{{__('ID')}}</th>
        <th>{{__('User Details')}}</th>
        <th>{{__('Wallet Balance')}}</th>
        <th>{{__('Status')}}</th>
        <th>{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($wallet_lists as $data)
        <tr>
            <td> {{ $data->id }} </td>
            <td>
                <ul class="list-inline">
                    <li class="list-item"><strong>{{__('Name')}}: </strong>{{optional($data->user)->name}}</li>
                    <li class="list-item"><strong>{{__('Email')}}: </strong>{{ optional($data->user)->email}}</li>
                    <li class="list-item"><strong>{{__('Phone')}}: </strong>{{ optional($data->user)->phone }}</li>
                </ul>
            </td>
            <td>{{ float_amount_with_currency_symbol($data->balance) }}</td>
            <td>
                <x-status.table.active-inactive :status="$data->status"/>
            </td>
            <td>
               <x-status.status-change :url="route('admin.wallet.status',$data->id)"/>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$wallet_lists"/>
