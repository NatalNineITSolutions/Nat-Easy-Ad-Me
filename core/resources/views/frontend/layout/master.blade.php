{{-- resources/views/frontend/layout/master.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF token for AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('site-title', config('app.name'))</title>

    <!-- Global CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Any page-specific CSS --}}
    @yield('style')

    {{-- Additional <head> includes (favicon, meta, etc.) --}}
    @include('frontend.layout.partials.header')
</head>
<body>

    {{-- Navbar --}}
    @include('frontend.layout.partials.navbar')

    {{-- Optional Breadcrumb --}}
    @if (!empty($page_post) && $page_post->breadcrumb_status == 'on')
        <div class="@if(Request::is('about') || Request::is('listings')) container-1920 plr1 @else container-1440 @endif">
            <nav aria-label="breadcrumb" class="frontend-breadcrumb-wrap breadcrumb-nav-part">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item">
                        <a href="#">{{ $page_post->title ?? '' }} @yield('inner-title')</a>
                    </li>
                </ol>
            </nav>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('frontend.layout.partials.footer')

    <!-- Inline tweaks that apply globally (if any) -->
    <style>
        .btn-wrapper .cmn-btn1 { width: 200px !important; }
        .heart { display: flex !important; align-items: center !important; justify-content: center !important; }
        @media (max-width: 768px) {
            .btn-wrapper .cmn-btn1 {
                width: 35px !important;
                height: 35px !important;
                border-radius: 50% !important;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2px !important;
            }
            .seller-img {
                width: 35px !important;
                height: 35px !important;
            }
        }
    </style>

    <!-- Global JS (jQuery → Select2 → Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJ+n2QH55GKa5--6/UEP5jhEc3+xUnMvrZhHE="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Page-specific scripts --}}
    @yield('scripts')
</body>
</html>