<div class="sidebar" data-background-color="custom">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="custom">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand" class="navbar-brand"
                    height="60" />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.guestAccount') ? 'active' : '' }}">
                    <a href="{{ route('admin.guestAccount') }}">
                        <i class="fa-solid fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.imrad') ? 'active' : '' }}">
                    <a href="{{ route('admin.imrad') }}">
                        <i class="fa-solid fa-book"></i>
                        <p>File Upload</p>

                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.announcement') ? 'active' : '' }}">
                    <a href="{{ route('admin.announcement') }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        <p>Announcement</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.log') ? 'active' : '' }}">
                    <a href="{{ route('admin.log') }}">
                        <i class="fa-solid fa-history"></i>
                        <p>Log History</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.trash-bin') ? 'active' : '' }}">
                    <a href="{{ route('admin.trash-bin') }}">
                        <i class="fa-solid fa-trash"></i>
                        <p>Trash Bin</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
