<nav class="bg-main navbar navbar-expand-md bg-maroon" id="navbar">
    <div class="container">
        @auth('guest_account')
            @if (!Str::contains(request()->path(), 'guest/account'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'You are currently logged in.',
                            text: 'Do you want to go to the Browser or log out?',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Logout',
                            cancelButtonText: 'Home',
                            customClass: {
                                confirmButton: 'btn btn-save',
                                cancelButton: 'btn btn-cite'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Logout confirmed!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    document.getElementById('logout-form-user').submit();
                                });
                            } else if (result.isDismissed) {
                                window.location.href = '{{ route('guest.account.home') }}';
                            }
                        });
                    });
                </script>
                <form id="logout-form-user" action="{{ route('guest.account.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
                <div class="logo">
                    <a href="{{ route('guest.account.home') }}" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand"
                            class="navbar-brand img-fluid" style="max-height: 50px;" />
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100">
                        <div>
                            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center justify-content-center">
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="{{ route('guest.account.home') }}">{{ __('Browse') }}</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="{{ route('guest.about.display') }}">{{ __('About') }}</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link"
                                        href="{{ route('guest.eresources.display') }}">{{ __('E-Resources') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="navbar-nav ms-auto align-items-center justify-content-center flex-row">
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="{{ route('guest.account.home.view.mylibrary') }}">
                                        <i class="fas fa-file"></i> {{ __('My Library') }}
                                    </a>
                                </li>

                                <li class="nav-item dropdown mx-2">
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                                        <a class="dropdown-item" href="{{ route('guest.account.logout') }}"
                                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('guest.account.logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                                @if (Auth::user()->profile)
                                    <img src="{{ asset('assets/img/guest_profile/' . Auth::user()->profile) }}"
                                        alt="Profile" class="rounded-circle profile-image mx-2"
                                        style="width: 40px; height: 40px; object-fit: cover;" />
                                @else
                                    <img src="{{ asset('assets/img/default.png') }}" alt="Profile"
                                        class="rounded-circle profile-image"
                                        style="width: 40px; height: 40px; object-fit: cover;" />
                                @endif
                                <li class="nav-item dropdown mx-2">
                                    <a id="navbarDropdownUserProfile"
                                        class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="ms-2">{{ Auth::user()->name }}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdownUserProfile">
                                        <a class="dropdown-item"
                                            href="{{ route('guest.account.profile', ['user_code' => encrypt(Auth::user()->user_code)]) }}">
                                            <i class="fa-solid fa-user me-2"></i>{{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('guest.account.logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('Logout') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <!-- For authenticated admins -->
        @auth('admin')
            @if (!Str::contains(request()->path(), 'admin') && Route::currentRouteName('admin.login'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'You are currently logged in.',
                            text: 'Do you want to go to Dashboard or log out?',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Logout',
                            cancelButtonText: 'Dashboard',
                            customClass: {
                                confirmButton: 'btn btn-save',
                                cancelButton: 'btn btn-cite'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire("Logout confirmed!", "", "success");
                                document.getElementById('logout-form-admin').submit();
                            } else if (result.isDismissed) {
                                window.location.href = '{{ route('admin.dashboard') }}';
                            }
                        });
                    });
                </script>
                <form id="logout-form-admin" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
        @endauth

        @auth('superadmin')
            @if (!Str::contains(request()->path(), 'superadmin') && Route::currentRouteName('admin.login'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'You are currently logged in.',
                            text: 'Do you want to go to Dashboard or log out?',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Logout',
                            cancelButtonText: 'Dashboard',
                            customClass: {
                                confirmButton: 'btn btn-save',
                                cancelButton: 'btn btn-cite'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire("Logout confirmed!", "", "success");
                                document.getElementById('logout-form-superadmin').submit();
                            } else if (result.isDismissed) {
                                window.location.href = '{{ route('superadmin.super_dashboard') }}';
                            }
                        });
                    });
                </script>
                <form id="logout-form-superadmin" action="{{ route('superadmin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
        @endauth

        <!-- For routes containing 'login' or the home route -->
        @if (Str::contains(Route::currentRouteName(), 'login') || Route::currentRouteName() === 'landing.page')
            <div class="logo">
                <a href="{{ route('landing.page') }}" class="logo">
                    <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand"
                        class="navbar-brand img-fluid" style="max-height: 50px;" />
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-end w-100">
                    <div>
                        <ul class="navbar-nav ms-auto text-center text-md-start">
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('guest.page') }}">{{ __('Browse') }}</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('about.display') }}">{{ __('About') }}</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link"
                                    href="{{ route('eresources.display') }}">{{ __('E-Resources') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <!-- For guests -->
            @guest
                <div class="logo">
                    <a href="{{ route('landing.page') }}" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand"
                            class="navbar-brand img-fluid" style="max-height: 50px;" />
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex justify-content-between w-100">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-end w-100">
                                <div>
                                    <ul class="navbar-nav ms-auto text-center text-md-start">
                                        <li class="nav-item mx-2">
                                            <a class="nav-link" href="{{ route('guest.page') }}">{{ __('Browse') }}</a>
                                        </li>
                                        <li class="nav-item mx-2">
                                            <a class="nav-link"
                                                href="{{ route('about.display') }}">{{ __('About') }}</a>
                                        </li>
                                        <li class="nav-item mx-2">
                                            <a class="nav-link"
                                                href="{{ route('eresources.display') }}">{{ __('E-Resources') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest
        @endif
    </div>
</nav>

<style>
    /* Custom Responsive Styles */
    .bg-maroon {
        background-color: #800000 !important;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        color: white !important;
    }

    @media (max-width: 768px) {
        .navbar-collapse {
            max-height: 80vh;
            overflow-y: auto;
        }

        .navbar-nav {
            flex-direction: column !important;
            align-items: center !important;
        }

        .nav-item {
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        .dropdown-menu {
            position: static;
            transform: none !important;
            margin-top: 10px;
            text-align: center;
            border: none;
            background-color: transparent;
        }

        .profile-image {
            margin: 0 auto 10px !important;
        }
    }
</style>
