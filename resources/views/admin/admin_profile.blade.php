@extends('layouts.admin')


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
                                                    action="{{ route('admin.profile.update', ['admin' => $admin]) }}">
                                                    @csrf

                                                    @method('PUT')
                                                    <div id="user_code1">
                                                        <div class="row mb-3">
                                                            <label for="user_code"
                                                                class="col-md-4 col-form-label text-md-end">{{ __('User Code') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="user_code" type="text"
                                                                    class="form-control @error('user_code') is-invalid @enderror"
                                                                    name="user_code"
                                                                    value="{{ old('user_code', $admin->user_code) }}"
                                                                    required autocomplete="user_code" readonly autofocus>

                                                                @error('user_code')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="name"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                name="name" value="{{ old('name', $admin->name) }}"
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
                                                                name="email" value="{{ old('email', $admin->email) }}"
                                                                required autocomplete="email">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="phone"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="phone" type="text"
                                                                class="form-control @error('phone') is-invalid @enderror"
                                                                name="phone" value="{{ old('phone', $admin->phone) }}"
                                                                autocomplete="phone">

                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="gender"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                                        <div class="col-md-6">
                                                            <select
                                                                class="form-select @error('gender') is-invalid @enderror"
                                                                id="gender" name="gender" required>
                                                                <option value="" disabled>Select Gender</option>
                                                                <option value="male"
                                                                    {{ old('gender', $admin->gender) == 'male' ? 'selected' : '' }}>
                                                                    Male</option>
                                                                <option value="female"
                                                                    {{ old('gender', $admin->gender) == 'female' ? 'selected' : '' }}>
                                                                    Female</option>
                                                                <option value="other"
                                                                    {{ old('gender', $admin->gender) == 'other' ? 'selected' : '' }}>
                                                                    Other</option>
                                                            </select>
                                                            @error('gender')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3" id="bday">
                                                        <label for="birthday"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="birthday" type="date"
                                                                class="form-control @error('birthday') is-invalid @enderror"
                                                                name="birthday"
                                                                value="{{ old('birthday', $admin->birthday) }}"
                                                                autocomplete="birthday" onchange="calculateAge()">

                                                            @error('birthday')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3" id="age-section">
                                                        <label for="age"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="age" type="number"
                                                                class="form-control @error('age') is-invalid @enderror"
                                                                name="age" value="{{ old('age', $admin->age) }}"
                                                                autocomplete="age" readonly>

                                                            @error('age')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    {{-- <div class="row mb-3">
                                                        <label for="profile"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('Profile') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="profile" type="file"
                                                                class="form-control @error('profile') is-invalid @enderror"
                                                                name="profile">

                                                            @error('profile')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div> --}}

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
                                                    action="{{ route('admin.profile.password.update', ['admin' => $admin]) }}">
                                                    <div id="user_code2" style="">

                                                        @csrf
                                                        @method('PUT')

                                                        <div class="row mb-3">
                                                            <label for="currpass"
                                                                class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="currpass" type="password"
                                                                    class="form-control @error('currpass') is-invalid @enderror"
                                                                    name="currpass" required
                                                                    autocomplete="current-password" autofocus>
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
                                @if ($admin->profile)
                                    <img src="{{ asset('assets/img/admin_profile/' . $admin->profile) }}" alt="Profile"
                                        class="rounded-circle" width="100%" height="100%">
                                @else
                                    <img src="{{ asset('assets/img/admin_profile/default.png') }}" alt="Profile"
                                        class="rounded-circle" width="100%" height="100%">
                                @endif

                                <div class="text-center mt-3">
                                    <h3>{{ $admin->name }}</h3>
                                </div>

                                <form method="POST" enctype="multipart/form-data" id="profileForm"
                                    action="{{ route('admin.profile.picture', ['admin' => $admin]) }}">
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
            let activeTabViewProfile = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabViewProfile) {
                activeTabViewProfile = localStorage.getItem('activeTabViewProfile') ||
                    'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabViewProfile}"]`);
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
                    localStorage.setItem('activeTabViewProfile', selectedTab);
                });
            });
        });
    </script>

@endsection
