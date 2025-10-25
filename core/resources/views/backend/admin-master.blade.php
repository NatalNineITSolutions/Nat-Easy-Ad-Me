<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <title>Document</title>
</head>

<style>
    <x-media.css />
</style>

<body>
<!-- preloader area start -->
@if(!empty(get_static_option('admin_loader_animation')))
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="loader_bars">
                <span></span>
            </div>
        </div>
    </div>
@endif
<!-- preloader area end -->
@include('backend/partials/header')
@include('backend/partials/sidebar')
<div class="dashboard__right">
    @include('backend/partials/top-header')
    <div class="dashboard__body posPadding">
        <div class="dashboard__inner">
            <div class="dashboard__inner__item">
                <div class="dashboard__inner__item__flex">
                    <div class="dashboard__inner__item__left bodyItemPadding">
                        <div class="body-overlay"></div>
                        <div class="dashboard__area">
                            <div class="container-fluid p-0">
                                <div class="dashboard__contents__wrapper">
                                     @yield('content')
                                </div>
                            </div>



                            <footer style="margin-top: 70px">
                                <div class="dashboard__card bg__white padding-20 radius-10">
                                    <div class="footer-area footer-wrap">
                                        {!! render_footer_copyright_text() !!}
                                        <p class="version">V-{{get_static_option('site_script_version')}}</p>
                                    </div>
                                </div>
                            </footer>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@include('backend/partials/footer')

<!-- <x-media.markup :type="'web'" /> -->
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJ+n2QH55GKa5--6/UEP5jhEc3+xUnMvrZhHE="
            crossorigin="anonymous"></script>

<!-- Bootstrap 4 (for jQuery modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- 
<x-media.js :type="'web'" /> -->
</html>

