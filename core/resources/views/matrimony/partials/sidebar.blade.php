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
</style>

<nav class="col-md-4 col-lg-3 d-md-block ">
    <div class="sidebar">
        <div class="profile">
            <h5 class="">{{ auth()->user()->username }}</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-heart"></i> My Matches</a></li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#profileDropdown">
                    <span><i class="fas fa-user"></i> Profile</span>
                    <i class="fas fa-chevron-down"></i> <!-- Dropdown Icon -->
                </a>
                <ul id="profileDropdown" class="collapse list-unstyled ms-4">
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.profile-lists') ? 'active' : '' }}" href="{{ route('matrimony.profile-lists') }}">
                            <i class="fas fa-list"></i> Profile Lists
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('matrimony.profile-listing') ? 'active' : '' }}" href="{{ route('matrimony.profile-listing') }}">
                            <i class="fas fa-user-circle"></i> Profile Listing
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link logout" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const currentUrl = window.location.href;

    // Find all nav links
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });
});
</script>