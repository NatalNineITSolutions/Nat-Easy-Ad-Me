@extends('frontend.layout.master')

@section('site_title')
    {{ __('Genology') }}
@endsection

@section('content')
    <div class="genology-full-width">
        <!-- MLM Tree Section -->
        @if (isset($mlmTree) && $mlmTree)
            <div class="mlm-tree box-shadow1">
                <h4 class="dis-title text-center text-white">{{ __('Genology') }}</h4>
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

