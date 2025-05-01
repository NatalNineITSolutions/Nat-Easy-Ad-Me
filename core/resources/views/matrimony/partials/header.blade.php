<header class="header">
    <div class="container header-container">
        <!-- Logo -->
        <a href="/matrimony" class="logo-link">
            <img class="logo" src="/assets/uploads/media-uploader/new-logo.png" alt="">
        </a>

        <!-- Desktop Navigation Links -->
        <nav>
            <ul class="nav-links">
                <li><a href="/matrimony">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="/matrimony/filter">Filter</a></li>
                <li><a href="/matrimony/profile">Profile</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>

        <!-- Right Side: Login/Register -->
        <div class="auth-buttons">

            <a href="#" class="position-relative d-inline-block">
                <i class="fa fa-bell fa-lg"></i>
                @if(($notificationCount ?? 0) > 0)
                    <span class="position-absolute top-[-10px] translate-middle badge rounded-pill bg-danger">
                        {{ $notificationCount }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </a>

            @if(auth()->check())
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center border-0 bg-transparent" 
                            type="button" 
                            id="authDropdown" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <img src="{{ auth()->user()->profile_image ?? '/assets/uploads/matrimony/avatar.png' }}" 
                             alt="Profile Image" 
                             class="rounded-circle" 
                             width="40" height="40">
                        <p class="profile mb-0 ms-2">{{ auth()->user()->username }}</p>
                    </button>

                    {{-- <button class="btn border-0 bg-transparent d-flex align-items-center">
                        <img src="{{ auth()->user()->profile_image ?? '/assets/uploads/matrimony/avatar.png' }}" 
                             alt="Profile Image" 
                             class="rounded-circle" 
                             width="40" height="40">
                        <span class="ms-2 username">{{ auth()->user()->username }}</span>
                    </button> --}}
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                        <li><a class="dropdown-item" href="/matrimony/profile">Profile</a></li>
                    </ul>
                </div>
            @endif
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <a href="#">Explore</a>
    <a href="#">All Pages</a>
    <a href="#">Top Pages</a>
    <a href="#">Plans</a>
    <a href="#">Register</a>
    <a href="/login">Login</a>
    <a href="/register">Register</a>
</div> 