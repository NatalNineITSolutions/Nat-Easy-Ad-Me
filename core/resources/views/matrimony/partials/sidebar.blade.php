<style>
    .sidebar {
        background-color: white;
        border-radius: 20px;
    }

    .profile {
        padding: 15px 20px;
    }

    .nav-item > .nav-link {
        padding: 10px 20px;
    }

    .nav-item > .nav-link:hover {
        background-color: rgb(209, 209, 209);
        
    }

    .nav-item li {
        padding: 0px 20px;
    }

    /* Apply background color to child list items only when hovered */
    .nav-item .collapse li:hover {
        background-color: rgb(209, 209, 209);
    }

    /* Remove background color from the parent when child list items are hovered */
    .nav-item .collapse li:hover ~ .nav-link {
        background-color: transparent;
    }

    .nav-item:hover .nav-link {
        color: black;
    }

    .nav-link {
        padding: 10px 20px;
        text-decoration: none;
        color: black;
        font-size: 13px;
        font-weight: 600;
    }

    .fas {
        margin-right: 12px;
        color: black;
    }

    .nav-item .nav-link.active {
        color: blue !important;
    }

    .nav-item .nav-link.active i {
        color: blue !important;
    }

    @media (max-width: 768px) {
    nav.col-md-4.col-lg-3 {
        position: relative;
        z-index: 9999;
        width: 100%;
    }

    .sidebar {
        position: relative;
        z-index: 9999;
        pointer-events: auto;
    }

    .sidebar a {
        pointer-events: auto;
    }
}

</style>

<nav class="col-md-4 col-lg-3 d-md-block ">
    <div class="sidebar">
        <div class="profile">
            <h5 class="">{{ auth()->user()->username }}</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('matrimony.dashboard') ? 'active' : '' }}" href="{{ route('matrimony.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#profileDropdown" id="profileToggle">
                    <span><i class="fas fa-user"></i>Profile Manage</span>
                    <i class="fas fa-chevron-down"></i> 
                </a>
                <ul id="profileDropdown" class="collapse list-unstyled ms-4">
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.profile') ? 'active' : '' }}" href="{{ route('matrimony.profile') }}">
                            <i class="fas fa-user"></i>Profile
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.profile-lists') ? 'active' : '' }}" href="{{ route('matrimony.profile-lists') }}">
                            <i class="fas fa-list"></i> Profile Lists
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.requests-lists') ? 'active' : '' }}" href="{{ route('matrimony.requests-lists') }}">
                            <i class="fas fa-ring"></i> Requests Sent
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.profile-listing') ? 'active' : '' }}" href="{{ route('matrimony.profile-listing') }}">
                            <i class="fas fa-user-circle"></i> Profile Listing
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li class="nav-item"><a class="nav-link logout" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a></li> --}}
        </ul>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ================= ACTIVE LINK HANDLER ================= */
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');

            const dropdown = link.closest('#profileDropdown');
            if (dropdown) {
                const bsCollapse = new bootstrap.Collapse(dropdown, { toggle: false });
                bsCollapse.show();

                const toggle = document.getElementById('profileToggle');
                if (toggle) toggle.classList.add('active');
            }
        }
    });

    /* ================= MOBILE MENU AUTO CLOSE ================= */
    const mobileMenu = document.getElementById("mobileMenu");
    if (mobileMenu) {
        mobileMenu.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                mobileMenu.classList.remove("show");
            });
        });
    }

    /* ================= CHEVRON TOGGLE ================= */
    const profileToggle = document.getElementById('profileToggle');
    if (profileToggle) {
        profileToggle.addEventListener('click', function () {
            const chevron = this.querySelector('.fa-chevron-down, .fa-chevron-up');
            const dropdown = document.getElementById('profileDropdown');

            if (!chevron || !dropdown) return;

            if (dropdown.classList.contains('show')) {
                chevron.classList.remove('fa-chevron-down');
                chevron.classList.add('fa-chevron-up');
            } else {
                chevron.classList.remove('fa-chevron-up');
                chevron.classList.add('fa-chevron-down');
            }
        });
    }

});
</script>
