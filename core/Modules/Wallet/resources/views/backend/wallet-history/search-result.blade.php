<table class="DataTable_activation">
    <thead>
    <tr>
        <th>{{__('No')}}</th>
        <th>{{__('User Details')}}</th>
        <th>{{__('Payment Gateway')}}</th>
        <th>{{__('Payment Status')}}</th>
        <th>{{__('Amount')}}</th>
        <th>{{__('Manual Payment Image')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($wallet_history_lists as $data)
        <tr>
            <td> {{ $data->id }} </td>
            <td>
                <ul class="list-inline">
                    <li><strong>{{__('Name')}}: </strong>{{ $data?->user?->fullname }} </li>
                    <li><strong>{{__('Email')}}: </strong>{{ $data?->user->email}}</li>
                    <li><strong>{{__('Phone')}}: </strong>{{ $data?->user->phone }}</li>
                </ul>
            </td>

            <td>{{ ucfirst($data->payment_gateway) }}</td>
            <td>
                <x-status.payment-status :status="$data->payment_status"/>
                @if($data->payment_status == 'pending')
                    <span><x-status.status-change :url="route('admin.wallet.history.status',$data->id)"/></span>
                @endif
            </td>
            <td>{{ float_amount_with_currency_symbol($data->amount) }}</td>
            <td>
                @can('complete-manual-deposit-status')
                    @if($data->manual_payment_image)
                        <a href="{{ url(asset('assets/uploads/deposit_payment_attachments/'.$data->manual_payment_image)) }}" target="_blank">
                            <img style="width:100px;" src="{{ asset('assets/uploads/deposit_payment_attachments/'.$data->manual_payment_image) }}" alt="payment-image">
                        </a>
                    @endif
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$wallet_history_lists"/>
