<div class="sidebar" data-background-color="custom">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="custom">
            <a href="{{ route('superadmin.super_dashboard') }}" class="logo">
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
                <li class="nav-item {{ Request::routeIs('superadmin.super_dashboard') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.super_dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('super_admin.admin') ? 'active' : '' }}">
                    <a href="{{ route('super_admin.admin') }}" aria-expanded="false">
                        <i class="fas fa-user-shield"></i>
                        <p>Admin Mngt</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('superadmin.trash-bin') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.trash-bin') }}" aria-expanded="false">
                        <i class="fas fa-trash"></i>
                        <p>Trash Bin</p>
                    </a>
                </li>

                {{-- <li class="nav-item {{ Request::routeIs('admin.user', 'admin.faculty') ? 'active' : '' }}">

                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fa-solid fa-users"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('super_admin/admin') ? 'active' : '' }}">
                                <a href="{{ route('super_admin.admin') }}">
                                    <span class="sub-item">Admin</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/faculty') ? 'active' : '' }}">
                                <a href="{{ route('admin.faculty') }}">
                                    <span class="sub-item">Faculty</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('super_admin/user') ? 'active' : '' }}">
                                <a href="{{ route('super_admin.user') }}">
                                    <span class="sub-item">Student</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/user') ? 'active' : '' }}">
                                <a href="{{ route('admin.user') }}">
                                    <span class="sub-item">Guest</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="#sidebarLayouts">
                        <i class="fa-solid fa-school"></i>
                        <p>Setting</p>
                    </a>
                </li> --}}

            </ul>
        </div>
    </div>
</div>
