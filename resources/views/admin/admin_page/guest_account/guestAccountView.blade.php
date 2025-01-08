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
                <div class="alert alert-success bg-primary text-white" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger bg-danger text-white" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-white">
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
                                        @if ($guestAccount->type === 'faculty')
                                            <li class="nav-item">
                                                <a class="nav-link" id="handled-account-tab" data-bs-toggle="tab"
                                                    href="#handled-account" role="tab" aria-controls="handled-account"
                                                    aria-selected="false" data-tab="handled">Thesis Advise</a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a class="nav-link" id="offline-account-tab" data-bs-toggle="tab"
                                                href="#offline-account" role="tab" aria-controls="offline-account"
                                                aria-selected="false" data-tab="offline">File Rating</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="saved-account-tab" data-bs-toggle="tab"
                                                href="#saved-account" role="tab" aria-controls="saved-account"
                                                aria-selected="false" data-tab="saved">File Saved</a>
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
                                        <!-- Thesis Advise Tab -->
                                        <div class="tab-pane fade" id="handled-account" role="tabpanel"
                                            aria-labelledby="handled-account-tab">
                                            <div class="container">
                                                <div class="table-responsive mt-3">
                                                    <div class="my-2">
                                                        <button type="button"
                                                            class="btn btn-maroon mb-3 mt-3 w-80 d-flex align-items-center justify-content-center"
                                                            data-bs-toggle="modal" data-bs-target="#thesisModal">
                                                            Add Thesis Advisee
                                                        </button>
                                                    </div>

                                                    <!-- Email Modal -->
                                                    <div class="modal fade" id="thesisModal" tabindex="-1"
                                                        aria-labelledby="thesisModalLabel" aria-hidden="true">
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fs-4 w-100 text-center"
                                                                        id="thesisModalLabel"><strong>Thesis Title and its
                                                                            Adviser</strong>
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close d-flex align-items-center justify-content-center"
                                                                        data-bs-dismiss="modal" aria-label="Close"> <i
                                                                            class="fs-3 fa-solid fa-xmark"></i></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div id="bulk-action-buttons"
                                                                        style="display: none; padding-left:10px;">
                                                                        <button id="add-selected" type="button"
                                                                            class="btn btn-primary mb-2">Add
                                                                            Advise</button>
                                                                    </div>

                                                                    <input type="hidden" id="user_id"
                                                                        value="{{ $guestAccount->user_code }}">
                                                                    <input type="hidden" id="user_type"
                                                                        value="{{ $guestAccount->type }}">

                                                                    <table id="basic-datatables-my-advise-list"
                                                                        class="display table table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col"><input type="checkbox"
                                                                                        id="select-all"></th>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Thesis title</th>
                                                                                <th scope="col">Adviser</th>
                                                                                <th scope="col">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="">
                                                                            @php
                                                                                $list = 1;
                                                                            @endphp
                                                                            @foreach ($thesisFileList as $thesis)
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="checkbox"
                                                                                            class="row-checkbox"
                                                                                            id="select-all"
                                                                                            value="{{ $thesis->id }}">
                                                                                    </td>
                                                                                    <td>{{ $list++ }}</td>
                                                                                    <td>{{ $thesis->title }}
                                                                                    <td>{{ $thesis->adviser }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="btn-group text-sm-center"
                                                                                            role="group"
                                                                                            aria-label="Basic mixed styles example">

                                                                                            <a href="{{ route('admin.imrad.view', ['imrad' => $thesis]) }}"
                                                                                                class="btn-primary btn">View</a>
                                                                                            </button>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <table id="basic-datatables-my-thesis-list"
                                                        class="display table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Thesis title</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="">
                                                            @php
                                                                $count = 1;
                                                            @endphp
                                                            @foreach ($myTheses as $thesis)
                                                                <tr>
                                                                    <td>{{ $count++ }}</td>
                                                                    <td>{{ $thesis->imrad->title }}</td>
                                                                    <td>
                                                                        <div class="btn-group text-sm-center"
                                                                            role="group"
                                                                            aria-label="Basic mixed styles example">

                                                                            <a href="{{ route('admin.imrad.view', ['imrad' => $thesis->imrad]) }}"
                                                                                class="btn-primary btn">View</a>

                                                                            <button
                                                                                class="btn btn-outline-secondary dropdown-toggle"
                                                                                type="button"
                                                                                id="actionDropdown{{ $count }}"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">

                                                                            </button>
                                                                            <ul class="dropdown-menu"
                                                                                aria-labelledby="actionDropdown{{ $count }}">
                                                                                <li>
                                                                                    <a href="#"
                                                                                        class="dropdown-item"
                                                                                        onclick="confirmUnselect(event, '{{ route('my-thesis.destroy', $thesis->id) }}')">Unselect</a>
                                                                                </li>
                                                                            </ul>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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

                    <div class="row mb-0">
                        <div>
                            <a href="{{ route('admin.guestAccount') }}" class="btn btn-secondary">
                                {{ __('Back') }}
                            </a>
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

            // Select all checkbox
            const selectAllCheckbox = document.getElementById("select-all");
            const rowCheckboxes = document.querySelectorAll(".row-checkbox");
            const bulkActionButtons = document.getElementById("bulk-action-buttons");

            const userId = document.getElementById("user_id").value;
            const userType = document.getElementById("user_type").value;



            const updateBulkActionButtons = () => {
                const anyChecked = Array.from(rowCheckboxes).some(checkbox => checkbox.checked);
                bulkActionButtons.style.display = anyChecked ? "block" : "none";
            };

            selectAllCheckbox.addEventListener("change", (e) => {
                rowCheckboxes.forEach(checkbox => checkbox.checked = e.target.checked);
                updateBulkActionButtons();
            });

            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateBulkActionButtons);
            });


            document.getElementById("add-selected").addEventListener("click", () => {
                const rowCheckboxes = document.querySelectorAll(".row-checkbox");
                const selectedIds = Array.from(rowCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    Swal.fire("No Selection", "Please select items to delete.", "warning");
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to add the selected items. This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/guestAccount/add-thesis', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({
                                    ids: selectedIds,
                                    user_code: userId,
                                    user_type: userType,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Response Data:', data);
                                Swal.fire("File added!", "The selected items have been added.",
                                    "success");
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error archiving:', error);
                                Swal.fire("Error!",
                                    "An error occurred while adding the items.", "error");
                            });
                    }
                });
            });
        });

        function confirmUnselect(event, deleteUrl) {
            event.preventDefault(); // Prevent default link behavior

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = deleteUrl;
                    form.method = 'POST';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

@endsection
