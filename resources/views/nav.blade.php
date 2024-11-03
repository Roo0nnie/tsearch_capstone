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
                            cancelButtonText: 'Home'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire("Logout confirmed!", "", "success");
                                document.getElementById('logout-form-user').submit();
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
                            class="navbar-brand" />
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownUser" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Menu') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                        <a class="dropdown-item" href="{{ route('landing.page') }}">{{ __('Home') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('About Us') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Browse') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownLinks" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Links') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownLinks">
                                        <a class="dropdown-item" href="#">{{ __('Link 1') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Link 2') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Link 3') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownHelp" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Help') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownHelp">
                                        <a class="dropdown-item" href="#">{{ __('Contact Us') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Resources and Help') }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('guest.account.home.view.mylibrary') }}">
                                        <i class="fas fa-file"></i> {{ __('My Library') }}
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="notification" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bell"></i>
                                    </a>

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
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownUserProfile"
                                        class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        @if (Auth::user()->profile)
                                            <img src="{{ asset('assets/img/guest_profile/' . Auth::user()->profile) }}"
                                                alt="Profile" class="rounded-circle" width="30" height="30">
                                        @else
                                            <img src="{{ asset('assets/img/default.png') }}" alt="Profile"
                                                class="rounded-circle" width="30" height="30">
                                        @endif
                                        <span class="ms-2">{{ Auth::user()->name }}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdownUserProfile">
                                        <a class="dropdown-item"
                                            href="{{ route('guest.account.profile', ['user_code' => encrypt(Auth::user()->user_code)]) }}">{{ __('Profile') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('guest.account.preference') }}">{{ __('Setting') }}</a>
                                        <a class="dropdown-item" href="{{ route('guest.account.logout') }}"
                                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
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
                            cancelButtonText: 'Dashboard'
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
                            cancelButtonText: 'Dashboard'
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
                <form id="logout-form-superadmin" action="{{ route('superadmin.logout') }}" method="POST"
                    class="d-none">
                    @csrf
                </form>
            @endif
        @endauth

        <!-- For routes containing 'login' or the home route -->
        @if (Str::contains(Route::currentRouteName(), 'login') || Route::currentRouteName() === 'landing.page')
            <div class="logo">
                <a href="{{ route('landing.page') }}" class="logo">
                    <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand"
                        class="navbar-brand" />
                </a>
            </div>
            {{-- <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Thesis Management System') }}
            </a> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <!-- Empty div for alignment -->
                    </div>
                    <div>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownGuest" class="nav-link dropdown-toggle" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ __('Menu') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownGuest">
                                    <a class="dropdown-item"
                                        href="{{ route('landing.page') }}">{{ __('Home') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('About Us') }}</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ __('Browse') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownGuestLinks" class="nav-link dropdown-toggle" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ __('Links') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="navbarDropdownGuestLinks">
                                    <a class="dropdown-item" href="#">{{ __('Link 1') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Link 2') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Link 3') }}</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownGuestHelp" class="nav-link dropdown-toggle" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ __('Help') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="navbarDropdownGuestHelp">
                                    <a class="dropdown-item" href="#">{{ __('Contact Us') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Resources and Help') }}</a>
                                </div>
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
                            class="navbar-brand" />
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownGuest" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('Menu') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownGuest">
                                        <a class="dropdown-item"
                                            href="{{ route('landing.page') }}">{{ __('Home') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('About Us') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">{{ __('Browse') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownGuestLinks" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('Links') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdownGuestLinks">
                                        <a class="dropdown-item" href="#">{{ __('Link 1') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Link 2') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Link 3') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownGuestHelp" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ __('Help') }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdownGuestHelp">
                                        <a class="dropdown-item" href="#">{{ __('Contact Us') }}</a>
                                        <a class="dropdown-item" href="#">{{ __('Resources and Help') }}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        {{-- <div>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <button type="button" class="nav-link text-white btn bg-primary"
                                        data-bs-toggle="modal" data-bs-target="#institutionalLogin">
                                        {{ __('Guest Registration') }}
                                    </button>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            @endguest
        @endif
    </div>
</nav>
