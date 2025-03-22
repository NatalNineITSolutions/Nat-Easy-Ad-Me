<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Add this to the <head> section -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/dynamic-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/common/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/fontawesome-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/common/css/toastr.min.css') }}">

    @include('frontend.layout.partials.root-style')

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .logo {
            width: 130px;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 20px;
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 15px;
            font-weight: bold;
            color: #b57e41;
            margin-bottom: 0;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #b57e41;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            display: none;
            min-width: 150px;
            border-radius: 5px;
            z-index: 10;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover {
            background: #f8f8f8;
        }

        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .profile {
            text-transform: capitalize;
            text-decoration: none;
            font-weight: 600;
            color: black;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 60px;
            left: 0;
            width: 100%;
            background: white;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .mobile-menu a {
            padding: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
            color: #333;
        }

        .mobile-menu a:hover {
            background: #f8f8f8;
        }

        .menu-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }

        .auth-buttons {
            display: flex;
            gap: 5px;
            cursor: pointer;
        }

        .auth-buttons .btn {
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .mobile-menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            width: 100%;
            background: white;
            padding: 10px;
            border-top: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.show {
            display: block;
        }

        .btn {
            border-radius: 0;
        }

        .nav-links li a {
            font-size: 13px;
            font-weight: 600;
            color: #66451C;
        }

        .login {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: rgb(196, 60, 60);
            background: transparent;
            border: 1px solid brown;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .login:hover {
            border: 1px solid brown;
            color: rgb(196, 60, 60);
        }

        .register {
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            background: rgb(196, 60, 60);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .register:hover {
            background: rgb(196, 60, 60);
            color: white;
        }

        @media (max-width: 992px) {
            .auth-buttons {
                display: none;
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .mobile-menu {
                display: none;
            }
        }

        .logo-link {
            text-decoration: none;
        }

        /* Footer Styling */
        .footer {
            background-color: #F5E6C8;
            /* Beige Background */
            color: #333;
            padding: 40px 0 20px 0;
        }

        .footer h5 {
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer ul li {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .footer a {
            color: #333;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer a:hover {
            color: #007bff;
        }

        .social-icons a {
            font-size: 18px;
            margin: 0 10px;
            color: #333;
            transition: 0.3s;
        }

        .social-icons a:hover {
            color: #007bff;
        }

        .footer-bottom {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }

        .join-btn {
            background-color: #5a6b72;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .join-btn:hover {
            background-color: #3e4d54;
        }
    </style>

    @yield('style')
</head>

<body>

    @include('matrimony.partials.header') <!-- Include the header -->

    <div class="content">
        @yield('content') <!-- Dynamic content section -->
    </div>

    @include('matrimony.partials.footer') <!-- Include the footer -->

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select elements
            const menuToggle = document.querySelector(".menu-toggle");
            const mobileMenu = document.getElementById("mobileMenu");

            // Toggle menu on click
            menuToggle.addEventListener("click", function() {
                mobileMenu.classList.toggle("show");
            });

            // Close menu when clicking outside
            document.addEventListener("click", function(event) {
                if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.remove("show");
                }
            });
        });
    </script>

    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>

    <x-payment.payment-gateway-js />
    @yield('script') <!-- Custom scripts section -->

</body>

</html>
