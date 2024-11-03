@extends('layouts.admin')


@section('content')

    <style>
        .toggle-arrow i {
            transition: transform 0.3s ease;
        }

        .toggle-arrow[aria-expanded="true"] i {
            transform: rotate(90deg);
            /* Arrow points left */
        }
    </style>

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
                        <h3 class="fw-bold mb-3">User Profile</h3>
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
                                                aria-selected="false" data-tab="online">File Preferences</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="offline-account-tab" data-bs-toggle="tab"
                                                href="#offline-account" role="tab" aria-controls="offline-account"
                                                aria-selected="false" data-tab="offline">File Rating</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="saved-account-tab" data-bs-toggle="tab"
                                                href="#saved-account" role="tab" aria-controls="saved-account"
                                                aria-selected="false" data-tab="offline">File Saved</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="invalid-account-tab" data-bs-toggle="tab"
                                                href="#invalid-account" role="tab" aria-controls="invalid-account"
                                                aria-selected="false" data-tab="invalid">Log History</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3">
                                        <!-- Basic Information Tab -->
                                        <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                            aria-labelledby="all-account-tab">
                                            <div class="container">

                                                <div id="user_code1">
                                                    <div class="row mb-3">
                                                        <label for="user_code"
                                                            class="col-md-4 col-form-label text-md-end">{{ __('User Code') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="user_code" type="text"
                                                                class="form-control @error('user_code') is-invalid @enderror"
                                                                name="user_code"
                                                                value="{{ old('user_code', $guestAccount->user_code) }}"
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
                                                            name="name" value="{{ old('name', $guestAccount->name) }}"
                                                            required readonly autocomplete="name" autofocus>

                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="email"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email', $guestAccount->email) }}"
                                                            required readonly autocomplete="email">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="phone"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="phone" type="text"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            name="phone"
                                                            value="{{ old('phone', $guestAccount->phone) }}"
                                                            autocomplete="phone" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gender"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="gender" type="text"
                                                            class="form-control @error('gender') is-invalid @enderror"
                                                            name="gender"
                                                            value="{{ old('gender', $guestAccount->gender) }}"
                                                            autocomplete="gender" readonly>

                                                    </div>
                                                </div>

                                                <div class="row mb-3" id="bday">
                                                    <label for="birthday"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="birthday" type="date"
                                                            class="form-control @error('birthday') is-invalid @enderror"
                                                            name="birthday"
                                                            value="{{ old('birthday', $guestAccount->birthday) }}"
                                                            autocomplete="birthday" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mb-3" id="age-section">
                                                    <label for="age"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="age" type="number"
                                                            class="form-control @error('age') is-invalid @enderror"
                                                            name="age" value="{{ old('age', $guestAccount->age) }}"
                                                            autocomplete="age" readonly>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <!-- File Information Tab -->
                                        <div class="tab-pane fade" id="online-account" role="tabpanel"
                                            aria-labelledby="online-account-tab">
                                            <div class="container">

                                                <div class="py-2 px-3">
                                                    <a data-bs-toggle="collapse" href="#collapseAuthor" role="button"
                                                        aria-expanded="false" aria-controls="collapseAuthor"
                                                        class="toggle-arrow">
                                                        Author List <i class="fas fa-chevron-right ms-4"></i>
                                                    </a>
                                                </div>
                                                <div class="collapse" id="collapseAuthor">
                                                    <div class="card card-body">
                                                        @forelse ($selectedAuthors as $selectedAuthor)
                                                            <li>{{ $selectedAuthor }}</li>
                                                        @empty
                                                            <li>No Author/s Selected</li>
                                                        @endforelse
                                                    </div>
                                                </div>

                                                <div class="py-2 px-3">
                                                    <a data-bs-toggle="collapse" href="#collapseAdviser" role="button"
                                                        aria-expanded="false" aria-controls="collapseAdviser"
                                                        class="toggle-arrow">
                                                        Adviser List <i class="fas fa-chevron-right ms-4"></i>
                                                    </a>
                                                </div>
                                                <div class="collapse" id="collapseAdviser">
                                                    <div class="card card-body">
                                                        @forelse ($selectedAdvisers as $selectedAdviser)
                                                            <li>{{ $selectedAdviser }}</li>
                                                        @empty
                                                            <li>No Adviser/s Selected</li>
                                                        @endforelse
                                                    </div>
                                                </div>

                                                <div class="py-2 px-3">
                                                    <a data-bs-toggle="collapse" href="#collapseDepartment"
                                                        role="button" aria-expanded="false"
                                                        aria-controls="collapseDepartment" class="toggle-arrow">
                                                        Department List <i class="fas fa-chevron-right ms-4"></i>
                                                    </a>
                                                </div>
                                                <div class="collapse" id="collapseDepartment">
                                                    <div class="card card-body">
                                                        @forelse ($selectedDepartments as $selectedDepartment)
                                                            <li>{{ $selectedDepartment }}</li>
                                                        @empty
                                                            <li>No Department's Selected</li>
                                                        @endforelse
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Invalid Users Tab -->
                                        <div class="tab-pane fade" id="offline-account" role="tabpanel"
                                            aria-labelledby="offline-account-tab">
                                            <!-- Content for File Rating Tab -->
                                            <div class="container">
                                                <div class="table-responsive mt-3">
                                                    <table id="basic-datatables-view"
                                                        class="display table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">File</th>
                                                                <th scope="col">Rate</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="admin-table-body">
                                                            @php
                                                                $count = 1;
                                                            @endphp
                                                            @foreach ($title_ratings as $rating)
                                                                <tr>
                                                                    <td>{{ $count++ }}</td>
                                                                    <td>{{ $rating->imrad_metric->imrad->title }}</td>
                                                                    <td>{{ $rating->rating }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="saved-account" role="tabpanel"
                                            aria-labelledby="saved-account-tab">
                                            <!-- Content for File Rating Tab -->
                                            <div class="container">
                                                <div class="table-responsive mt-3">
                                                    <table id="basic-datatables-view-2"
                                                        class="display table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">File</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="admin-table-body">
                                                            @php
                                                                $count = 1;
                                                            @endphp
                                                            @foreach ($saved as $title)
                                                                <tr>
                                                                    <td>{{ $count++ }}</td>
                                                                    <td>{{ $title->imrad->title }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="invalid-account" role="tabpanel"
                                            aria-labelledby="invalid-account-tab">
                                            <!-- Content for User Log History Users Tab -->
                                            <div class="container">
                                                <div class="table-responsive mt-3">
                                                    <table id="basic-datatables-view-1"
                                                        class="display table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Login</th>
                                                                <th scope="col">Logout</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="admin-table-body">
                                                            @php
                                                                $count = 1;
                                                            @endphp
                                                            @foreach ($logs as $log)
                                                                @if ($log->user_code == $guestAccount->user_code)
                                                                    <tr>
                                                                        <td>{{ $count++ }}</td>
                                                                        <td>{{ $log->name }}</td>
                                                                        <td>{{ $log->login }}</td>
                                                                        <td>{{ $log->logout }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
                                    <img src="{{ asset('assets/img/guest_profile/' . $guestAccount->profile) }}"
                                        alt="Profile" class="rounded-circle" width="100%" height="100%">
                                    <div class="text-center mt-3">
                                        <h3>{{ $guestAccount->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabView = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabView) {
                activeTabView = localStorage.getItem('activeTabView') || 'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabView}"]`);
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
                    localStorage.setItem('activeTabView', selectedTab);
                });
            });
        });
    </script>

@endsection
