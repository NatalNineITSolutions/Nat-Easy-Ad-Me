@extends('frontend.layout.master')

@section('site_title')
    {{ __('Genology') }}
@endsection

@section('content')
    <div class="genology-full-width">
        <!-- MLM Tree Section -->
        @if (isset($mlmTree) && $mlmTree)
            <div class="mlm-tree box-shadow1">
                <h4 class="dis-title text-center">{{ __('Genology') }}</h4>
                <div class="tree">
                    <ul>
                        <li>
                            @include('frontend.user.genology.partials.tree-node', ['node' => $mlmTree, 'position' => 'root'])
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <p class="text-center">{{ __('No MLM Data Found') }}</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/js/sweetalert2.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('style')
    <style>
        /* Full-width container */
        .genology-full-width {
            width: 100%;
            margin: 0;
            padding: 0;
            overflow-x: auto; /* Allow horizontal scrolling if needed */
        }

        .mlm-tree {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Center the tree with some margin */
        }

        .tree {
            width: 100%;
            padding: 20px 0;
            overflow-x: auto; /* Allow horizontal scrolling if needed */
        }

        .tree ul {
            padding-left: 0;
            position: relative;
            display: flex;
            justify-content: center;
        }

        .tree li {
            width: 100%;
            list-style-type: none;
            margin: 0;
            padding: 0px 5px 0 5px;
            position: relative;
            text-align: center;
        }

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            border: 1px solid #ddd;
        }

        .tree li::before {
            border-left: 2px solid #ddd;
            height: 20px;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .tree li::after {
            border-top: 2px solid #ddd;
            width: 100%;
            top: 0;
            left: 0;
        }

        .tree>ul>li::before,
        .tree>ul>li::after {
            display: none;
        }

        .tree ul ul::before {
            content: '';
            position: absolute;
            border-left: 2px solid #ddd;
            height: 20px;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .tree li div.node {
            border-radius: 8px;
            padding: 10px;
            display: inline-block;
            min-width: 160px;
            text-align: center;
            font-family: Arial, sans-serif;
            position: relative;
            z-index: 1;
        }

        .tree li.left-branch>div.node,
        .tree li.left-branch {
            background-color: #ffdddd;
        }

        .tree li.right-branch>div.node,
        .tree li.right-branch {
            background-color: #ddffff;
        }

        .tree li div.root-node {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #1a237e;
            margin: 0 auto 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle.empty {
            background-color: #ffffff;
            border: 2px solid #1a237e;
        }

        .avatar-inner {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ffffff;
        }

        .empty .avatar-inner {
            background-color: #1a237e;
        }

        .node-id {
            display: block;
            font-size: 12px;
            color: #333;
            margin-bottom: 2px;
        }

        .node-name {
            display: block;
            font-weight: bold;
            font-size: 14px;
            color: #000;
            margin-bottom: 5px;
        }

        .bv-points {
            font-size: 12px;
            color: #333;
            margin-top: 5px;
        }

        .bv-points strong {
            font-weight: bold;
            color: #000;
        }

        .direction-arrow {
            color: #666;
            margin: 0 5px;
        }

        .user-count {
            color: #1a237e;
        }

        .add-member-node {
            margin-top: 10px;
        }

        .add-icon {
            width: 30px;
            height: 30px;
            background-color: #4caf50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            cursor: pointer;
        }

        .add-icon i {
            font-size: 16px;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .tree {
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            .tree {
                min-width: auto;
            }

            .tree li div.node {
                min-width: 120px;
            }
        }
    </style>
@endsection