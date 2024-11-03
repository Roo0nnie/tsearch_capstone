@extends('layouts.super_admin')


@section('content')
    <div>
        <div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">My Profile</h3>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="row">
                        <!-- For large screens, div1 takes 7 columns, div2 takes 5 columns -->
                        <!-- For medium screens, both div1 and div2 take 6 columns each -->
                        <!-- For small screens, div2 takes full width (12 columns) and is placed above div1 -->

                        <!-- div2 (Top on small screens, left on larger screens) -->
                        <div class="col-lg-8 col-md-6 col-12 order-2 order-md-1 order-lg-1">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="all-account-tab" data-bs-toggle="tab"
                                                href="#all-account" role="tab" aria-controls="all-account"
                                                aria-selected="false" data-tab="all">Basic information</a>

                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="online-account-tab" data-bs-toggle="tab"
                                                href="#online-account" role="tab" aria-controls="online-account"
                                                aria-selected="false" data-tab="online">Change Password</a>
                                        </li>

                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3">
                                        <!-- Basic Information Tab -->
                                        <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                            aria-labelledby="all-account-tab">
                                            <div class="container">
                                                <form method="POST" enctype="multipart/form-data" id="profileForm"
                                                    action="{{ route('superadmin.profile.update', ['superadmin' => $superadmin]) }}">
                                                    @csrf

                                                    @method('PUT')
                                                    <div class="row mb-3">
                                                        <label for="name"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name', $superadmin->name) }}"
                                                                required autocomplete="name" autofocus>

                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="row mb-3">
                                                        <label for="email"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                name="email"
                                                                value="{{ old('email', $superadmin->email) }}" required
                                                                autocomplete="email">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Update Profile') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- File Information Tab -->
                                        <div class="tab-pane fade" id="online-account" role="tabpanel"
                                            aria-labelledby="online-account-tab">
                                            <div class="container">
                                                {{-- password --}}

                                                <form method="POST"
                                                    action="{{ route('superadmin.profile.password.update', ['superadmin' => $superadmin]) }}">
                                                    <div id="user_code2" style="">

                                                        @csrf
                                                        @method('PUT')

                                                        <div class="row mb-3">
                                                            <label for="currpass"
                                                                class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="currpass" type="password"
                                                                    class="form-control @error('currpass') is-invalid @enderror"
                                                                    name="currpass" required autocomplete="current-password"
                                                                    autofocus>
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong id="currpass-error">The current password is
                                                                        incorrect.</strong>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="password"
                                                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                                            <div class="col-md-6">
                                                                <input id="password1" type="password"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    name="password" required autocomplete="new-password">
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="password-confirm"
                                                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                                            <div class="col-md-6">
                                                                <input id="password-confirm1" type="password"
                                                                    class="form-control" name="password_confirmation"
                                                                    required autocomplete="new-password">
                                                                @error('password_confirmation')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-0">
                                                            <div class="col-md-6 offset-md-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ __('Update Password') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- div1 (Bottom on small screens, right on larger screens) -->
                    <div class="col-lg-4 col-md-6 col-12 order-1 order-md-2 order-lg-2">
                        <div class="card">
                            <div class="card-body">
                                @if ($superadmin->profile)
                                    <img src="{{ asset('assets/img/superadmin_profile/' . $superadmin->profile) }}"
                                        alt="Profile" class="rounded-circle" width="100%" height="100%">
                                @else
                                    <img src="{{ asset('assets/img/superadmin_profile/default.png') }}" alt="Profile"
                                        class="rounded-circle" width="100%" height="100%">
                                @endif

                                <div class="text-center mt-3">
                                    <h3>{{ $superadmin->name }}</h3>
                                </div>

                                <form method="POST" enctype="multipart/form-data" id="profileForm"
                                    action="{{ route('superadmin.profile.picture', ['superadmin' => $superadmin]) }}">
                                    @csrf

                                    @method('PUT')
                                    <div class="row mb-3">
                                        <div class="col-md-6 d-flex justify-center align-content-center w-100 h-100">
                                            <input id="profile" type="file"
                                                class="form-control @error('profile') is-invalid @enderror"
                                                name="profile">

                                            @error('profile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Picture') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function calculateAge() {
            const birthdayInput = document.getElementById('birthday');
            const ageInput = document.getElementById('age');

            if (birthdayInput.value) {
                const birthDate = new Date(birthdayInput.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                ageInput.value = age;
            } else {
                ageInput.value = '';
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabViewProfilesuper = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabViewProfilesuper) {
                activeTabViewProfilesuper = localStorage.getItem('activeTabViewProfilesuper') ||
                    'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabViewProfilesuper}"]`);
            if (tabToActivate) {
                var tab = new bootstrap.Tab(tabToActivate);
                tab.show();

                // Activate the content
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('show', 'active'); // Hide other tab panes
                });
                let contentId = tabToActivate.getAttribute('href');
                document.querySelector(contentId).classList.add('show', 'active');
            }

            // Store active tab in local storage when clicked
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let selectedTab = event.target.getAttribute('data-tab');
                    localStorage.setItem('activeTabViewProfilesuper', selectedTab);
                });
            });
        });
    </script>

@endsection
