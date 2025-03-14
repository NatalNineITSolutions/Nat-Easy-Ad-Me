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
                <li><a href="#">Profile</a></li>
                <li><a href="#">Search</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>

        <!-- Right Side: Login/Register -->
        <div class="auth-buttons">
        
            @if(isset($user) && $user)
                <a href="#" class="btn profile">Profile</a>
            @else
                <a href="{{ route('matrimony.login') }}" class="btn login">Login</a>
                <a href="{{ route('matrimony.register') }}" class="btn register">Register</a>
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