@extends('layouts.admin')


@section('content')
    <div>
        <div>
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">My Profile</h3>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="row">

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
                                                                required autocomplete="email" readonly>

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
                                        <!-- Password Tab -->
                                        <div class="tab-pane fade" id="online-account" role="tabpanel"
                                            aria-labelledby="online-account-tab">
                                            <div class="container">

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

                                                                @error('currpass')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
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

                                                                <div class="mt-2">
                                                                    <ul>
                                                                        <li id="length" class="text-danger">Must be at
                                                                            least 8 characters</li>
                                                                        <li id="uppercase" class="text-danger">Must
                                                                            include an
                                                                            uppercase letter</li>
                                                                        <li id="lowercase" class="text-danger">Must
                                                                            include a
                                                                            lowercase letter</li>
                                                                        <li id="number" class="text-danger">Must
                                                                            include a
                                                                            number</li>
                                                                        <li id="special" class="text-danger">Must
                                                                            include a
                                                                            special character (@, $, !, %, *, ?, &)</li>
                                                                    </ul>
                                                                </div>


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

                        <div class="row mb-0">
                            <div>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>



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


        document.getElementById("password1").addEventListener("input", function() {
            const password = this.value;

            const validations = [{
                    id: "length",
                    test: password.length >= 8
                },
                {
                    id: "uppercase",
                    test: /[A-Z]/.test(password)
                },
                {
                    id: "lowercase",
                    test: /[a-z]/.test(password)
                },
                {
                    id: "number",
                    test: /\d/.test(password)
                },
                {
                    id: "special",
                    test: /[@$!%*?&]/.test(password)
                },
            ];

            validations.forEach(validation => {
                const element = document.getElementById(validation.id);
                if (validation.test) {
                    element.classList.remove("text-danger");
                    element.classList.add("text-success", "visible");
                } else {
                    element.classList.remove("text-success");
                    element.classList.add("text-danger", "visible");
                }
            });

        });
    </script>
@endsection
