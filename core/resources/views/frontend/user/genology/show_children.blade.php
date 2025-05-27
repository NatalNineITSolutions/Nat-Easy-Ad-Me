@extends('frontend.layout.master')

@section('site_title')
    {{ __('MLM Tree - Parent Details') }}
@endsection

@section('content')
    <div class="genology-full-width">
        <div class="mlm-tree box-shadow1">
            <h4 class="dis-title text-center text-white">
                From the sponser of {{ $parent->parent->partner_id ?? __('MLM Tree') }}
            </h4>
            <div class="tree">
                <ul>
                    <li>
                        {{-- Render the parent node --}}
                        <div class="node root-node">
                            <div
                                class="avatar-circle {{ $parent->gender == 'female' ? 'female' : 'male' }} 
                                        {{ ($parent->leftBV ?? 0) == 0 && ($parent->rightBV ?? 0) == 0 ? 'zero-bv' : '' }}">
                                <a href="{{ route('user.user.mlm.children', ['id' => $parent->id]) }}">
                                    @if($parent->avatar)
                                        <img src="{{ asset($parent->avatar) }}" alt="User Avatar">
                                    @else
                                        <img src="{{ asset($parent->gender == 'female' ? 'assets/uploads/media-uploader/girlavatart.jpg' : 'assets/uploads/media-uploader/avatar.jpg') }}"
                                            alt="Default Avatar">
                                    @endif
                                </a>
                            </div>
                            <span class="node-id">{{ $parent->partner_id ?? 'N/A' }}</span>
                            <span class="node-name">{{ $parent->first_name ?? 'N/A' }}</span>
                            <div class="bv-points">
                                <span>BV (L): <strong>{{ $parent->leftBV ?? 0 }}</strong></span>
                                <span>BV (R): <strong>{{ $parent->rightBV ?? 0 }}</strong></span>
                            </div>
                            <div class="possible-pairs">
                                <span>Possible Pairs: <strong>{{ $possiblePairs }}</strong></span>
                            </div>
                        </div>
                        <ul>
                            <li>
                                @if ($parent->leftChild)
                                    {{-- Render left child --}}
                                    @include('frontend.user.genology.partials.tree-node', ['node' => $parent->leftChild, 'isChild' => true])
                                @else
                                    <div class="add-member-node">
                                        <a
                                            href="{{ route('user.mlm.addNewMember', ['sponsor' => $parent->id, 'position' => 'left']) }}">
                                            <div class="add-icon">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </li>
                            <li>
                                @if ($parent->rightChild)
                                    {{-- Render right child --}}
                                    @include('frontend.user.genology.partials.tree-node', ['node' => $parent->rightChild, 'isChild' => true])
                                @else
                                    <div class="add-member-node">
                                        <a
                                            href="{{ route('user.mlm.addNewMember', ['sponsor' => $parent->id, 'position' => 'right']) }}">
                                            <div class="add-icon">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/js/sweetalert2.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('style')
    <style>
        .mlm-tree {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .full-width {
            background-color: #008081;
            overflow-x: auto;
        }

        .new-style .box-shadow1 {
            background-color: #008081;
            border: none;
        }

        .add-icon {
            color: white;
            font-size: 30px;
            position: relative;
            left: 6px;
        }

        .tree {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .tree ul {
            display: flex;
            justify-content: center;
            padding: 0;
            list-style: none;
            width: 100%;
        }

        .tree li {
            position: relative;
            padding: 10px 20px;
            width: 100%;
        }

        .tree li::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 30px;
            background: white;
        }

        .node {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #008081;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(255, 255, 255, 0.2);
        }

        .node-id,
        .node-name,
        .bv-points {
            color: white !important;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            background: #1a237e;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            position: relative;
        }

        .possible-pairs {
            margin-top: 6px;
            padding: 6px 12px;
            background: #ffeb3b;
            border: 2px solid #fbc02d;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            animation: pulse-highlight 2s ease-in-out infinite;
        }

        .possible-pairs span {
            color: #212121;
            font-weight: bold;
            font-size: 1rem;
        }
    </style>
@endsection