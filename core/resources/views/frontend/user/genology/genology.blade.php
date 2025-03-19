@extends('frontend.layout.master')

@section('site_title')
    {{ __('Genology') }}
@endsection

@section('content')
    <div class="profile-setting my-account section-padding2">
        <div class="container-1920 plr1">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')
                            <div class="main-body">
                                <!-- MLM Tree Section -->
                                @if (isset($mlmTree) && $mlmTree)
                                    <div class="mlm-tree-container box-shadow1 mt-20">
                                        <h4 class="dis-title text-center">{{ __('Genology') }}</h4>
                                        <div class="tree">
                                            <ul>
                                                <li>
                                                    <div class="node">
                                                        <span class="node-name">{{ $mlmTree->first_name ?? 'N/A' }}</span>
                                                        <span class="node-id">{{ $mlmTree->partner_id ?? 'N/A' }}</span>
                                                        <div class="bv-points">
                                                            <span> BV (L) : <strong>{{ $leftBV }}</strong> </span>
                                                            <span> BV (R) : <strong>{{ $rightBV }}</strong> </span>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <!-- Left Slot -->
                                                        <li>
                                                            @if ($mlmTree->leftChild)
                                                                @include(
                                                                    'frontend.user.genology.partials.tree-node',
                                                                    ['node' => $mlmTree->leftChild]
                                                                )
                                                            @else
                                                                <div class="node placeholder">
                                                                    <a
                                                                        href="{{ route('user.mlm.addNewMember', ['sponsor' => $mlmTree->id, 'position' => 'left']) }}">
                                                                        {{ __('Add New Member') }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </li>
                                                        <!-- Right Slot -->
                                                        <li>
                                                            @if ($mlmTree->rightChild)
                                                                @include(
                                                                    'frontend.user.genology.partials.tree-node',
                                                                    ['node' => $mlmTree->rightChild]
                                                                )
                                                            @else
                                                                <div class="node placeholder">
                                                                    <a
                                                                        href="{{ route('user.mlm.addNewMember', ['sponsor' => $mlmTree->id, 'position' => 'right']) }}">
                                                                        {{ __('Add New Member') }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center">{{ __('No MLM Data Found') }}</p>
                                @endif
                            </div><!-- main-body -->
                        </div><!-- down-body-wraper -->
                    </div><!-- profile-setting-wraper -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/js/sweetalert2.js') }}"></script>
@endsection

@section('style')
    <style>
        .mlm-tree-container {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .tree ul {
            padding-left: 0;
            position: relative;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-items: center;
        }

        .tree li {
            list-style-type: none;
            margin: 0;
            padding: 20px 10px 0 10px;
            position: relative;
            text-align: center;
        }

        .tree li::before {
            content: '';
            position: absolute;
            border-left: 1.5px solid #ddd;
            height: 25px;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .tree li::after {
            content: '';
            position: absolute;
            border-top: 1.5px solid #ddd;
            height: 1px;
            top: -15px;
            left: 0;
            width: 100%;
        }

        .tree>ul>li::before,
        .tree>ul>li::after {
            display: none;
        }

        .tree li div.node {
            border-radius: 8px;
            padding: 12px;
            background: #fff;
            display: inline-block;
            min-width: 160px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            font-family: Arial, sans-serif;
            border: 1px solid #ddd;
            margin-top: 8px;
        }

        .tree li div.node .node-name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .tree li div.node .node-id {
            font-size: 12px;
            color: #666;
            display: block;
            margin-top: 5px;
        }

        .node.placeholder {
            background: #f5f5f5;
            border: 1px dashed #ccc;
            box-shadow: none;
        }

        .node.placeholder a {
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            color: #007bff;
        }

        .node.placeholder a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
