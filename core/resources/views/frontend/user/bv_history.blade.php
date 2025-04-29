@extends('frontend.layout.master')

@section('site-title')
    {{ __('BV History') }}
@endsection

@section('style')
    <style>
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

        @media (max-width: 768px) {
            table thead {
                display: none;
            }

            table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
                background-color: #fff;
            }

            table tbody tr td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 10px;
                border: none;
                border-bottom: 1px solid #eee;
            }

            table tbody tr td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #333;
                flex-basis: 40%;
            }

            table tbody tr td:last-child {
                border-bottom: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="profile-setting setting-page section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')
                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')
                            <div class="main-body">
                                <x-frontend.user.responsive-icon />
                                <div class="setting-btn-part">
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="tab-content-wraper box-shadow1">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h3 class="head4">{{ __('BV History') }}</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>BV Points</th>
                                                                <th>Type</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($bvHistory as $index => $bv)
                                                                <tr>
                                                                    <td data-label="#">{{ $index + 1 }}</td>
                                                                    <td data-label="BV Points">{{ $bv->bv_points }}</td>
                                                                    <td data-label="Type">{{ ucfirst($bv->type ?? 'N/A') }}</td>
                                                                    <td data-label="Date">{{ $bv->created_at->format('d M Y h:i A') }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No BV history found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="save-change-btn mt-4">
                                                    {{ $bvHistory->links() }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection