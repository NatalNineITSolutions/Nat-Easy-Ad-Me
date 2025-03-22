@if($all_enquiries->count() > 0)
    <table class="table">
        <thead class="table-light">
            <tr>
                <th>{{ __('Id') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Message') }}</th>
                <th>{{ __('Created At') }}</th>
                <th class="resume-column" style="display: none;">{{ __('Resume') }}</th> <!-- Hide by default -->
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_enquiries as $data)
                <tr data-category-id="{{ $data->listing?->category_id ?? '' }}">
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->phone }}</td>
                    <td>{{ $data->message }}</td>
                    <td>{{ $data->created_at->format('Y-m-d') ?? '' }}</td>
                    <td class="resume-column" style="display: none;">
                        @if($data->resume)
                            <a href="{{ asset($data->resume) }}" target="_blank"
                                style="color: blue; text-decoration: underline; font-weight: bold;">
                                View PDF
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="action-table-cell">
                        <x-popup.delete-popup :url="route('user.enquiry.form.delete', $data->id)" />
                        @if(!empty($data->listing))
                            <div class="btn-wrapper">
                                <a class="cmn-btn2 cmn-btn-info"
                                    href="{{ route('frontend.listing.details', $data->listing?->slug ?? 'x') }}"
                                    target="_blank">{{ __('View Listing') }}</a>
                            </div>
                        @else
                            <span>{{ __('No Listing yet') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="deposit-history-pagination mt-4">
        <x-pagination.laravel-paginate :allData="$all_enquiries" />
    </div>
@else
    <x-pagination.empty-data-placeholder :title="__('No Enquiries Yet')" />
@endif