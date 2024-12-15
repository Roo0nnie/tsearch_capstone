@auth('admin')
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="custom">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand" class="navbar-brand"
                    height="20" />
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
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">


            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" aria-haspopup="true">
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                        <form class="navbar-left navbar-form nav-search">
                            <div class="input-group">
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </form>
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        @if (Auth::user()->profile)
                            <img src="{{ asset('assets/img/admin_profile/' . Auth::user()->profile) }}" alt="Profile"
                                class="rounded-circle" width="30" height="30">
                        @else
                            <img src="{{ asset('assets/img/admin_profile/default.png') }}" alt="Profile"
                                class="rounded-circle" width="100%" height="100%">
                        @endif
                        <span class="profile-username">
                            <span class="fw-bold">{{ Auth::guard('admin')->user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">

                                    <div class="u-text">
                                        <h4>{{ Auth::guard('admin')->user()->name }}</h4> <!-- Dynamic admin name -->
                                        <p class="text-muted">{{ Auth::guard('admin')->user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{ route('admin.profile', ['admin' => encrypt(Auth::guard('admin')->user()->id)]) }}">
                                    Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.setting') }}">
                                    Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form-admin').submit();">
                                    Logout
                                </a>
                            </li>
                        </div>
                    </ul>
                </li>
                <form id="logout-form-admin" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
@endauth
