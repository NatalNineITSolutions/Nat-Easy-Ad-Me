<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .navbar {
            padding: 10px 0;
        }

        .navbar-brand img {
            border-radius: 50%;
        }

        .navbar-nav .nav-link {
            font-size: 16px;
            font-weight: 500;
            padding: 10px 15px;
            transition: color 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .btn {
            font-size: 14px;
            font-weight: 500;
        }

        /* Footer Styling */
        .footer {
            background-color: #F5E6C8; /* Beige Background */
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.querySelector(".menu-toggle");
            const navLinks = document.querySelector(".nav-links");

            menuToggle.addEventListener("click", function () {
                navLinks.classList.toggle("active");
            });
        });
    </script>

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    @yield('script') <!-- Custom scripts section -->

</body>
</html>