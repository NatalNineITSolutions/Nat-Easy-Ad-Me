<style>
    /* Sidebar Styles */
    .branch-sidebar {
        background: white;
        width: 280px;
        height: calc(100vh - 80px);
        position: fixed;
        left: 0;
        top: 80px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
        transition: all 0.3s ease;
        z-index: 99;
    }

    .sidebar-menu {
        padding: 1.5rem 0;
    }

    .menu-item {
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--dark-color);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .menu-item:hover,
    .menu-item.active {
        background-color: #F8FAFC;
        color: var(--primary-color);
        border-left-color: var(--primary-color);
    }

    .menu-item i {
        width: 20px;
        text-align: center;
    }
</style>

<aside class="branch-sidebar" id="branchSidebar">
    <nav class="sidebar-menu">
        <a href="{{ route('branch.dashboard') }}"
           class="menu-item {{ request()->routeIs('branch.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('branch.products.all') }}"
           class="menu-item {{ request()->routeIs('branch.products.*') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i>
            <span>All Products</span>
        </a>

        <a href="{{ route('branch.orders.history') }}"
           class="menu-item {{ request()->routeIs('branch.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Order History</span>
        </a>
        
        <a href="{{ route('branch.commission') }}"
            class="menu-item {{ request()->routeIs('branch.commission') ? 'active' : '' }}">
            <i class="fas fa-percent"></i>
            <span>{{ __('Commission') }}</span>
        </a>
    </nav>
</aside>