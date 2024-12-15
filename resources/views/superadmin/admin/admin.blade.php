@extends('layouts.super_admin')

@section('content')
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
                    <h3 class="fw-bold mb-3">Admin</h3>
                </div>
            </div>

            <div class="container">

                <div class="d-flex justify-content-end">
                    <div>
                        <a href="{{ route('super_admin.admin.create') }}">
                            <button class="btn bg-primary">Add Admin</button>
                        </a>
                    </div>
                </div>
            </div>


            <div class="container mt-3 ">
                <div class="card table-responsive">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="all-account-tab" data-bs-toggle="tab" href="#all-account"
                                    role="tab" aria-controls="all-account" aria-selected="false" data-tab="all">All
                                    Admin</a>

                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3">
                            <!-- All Users Tab -->
                            <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                aria-labelledby="all-account-tab">
                                <div class="container">
                                    <div>
                                        <div id="admin-table">
                                            <table class="table table-striped" id="basic-datatables">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Code</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Birthday</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="admin-table-body">
                                                    @foreach ($admins as $admin)
                                                        @if ($admin->action === null)
                                                            <tr>
                                                                <td></td>
                                                                <td>{{ $admin->user_code }}</td>
                                                                <td>{{ $admin->name }}</td>
                                                                <td>{{ $admin->email }}</td>
                                                                <td>{{ $admin->phone }}</td>
                                                                <td>{{ $admin->birthday }}</td>
                                                                <td>{{ $admin->status }}</td>
                                                                <td>

                                                                    <div class="btn-group text-sm-center" role="group"
                                                                        aria-label="Basic mixed styles example">

                                                                        <a href="{{ route('superadmin.admin.view', ['admin' => $admin]) }}"
                                                                            class="btn-primary btn">View</a>
                                                                        <button
                                                                            class="btn btn-outline-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="actionDropdown{{ $admin->id }}"
                                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">

                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="actionDropdown{{ $admin->id }}">
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('super_admin.admin.delete', ['admin' => $admin]) }}"
                                                                                    method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="dropdown-item">Delete</button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                        </button>
                                                                    </div>
                                                                </td>
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
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabsuper = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabsuper) {
                activeTabsuper = localStorage.getItem('activeTabsuper') || 'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabsuper}"]`);
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
                    localStorage.setItem('activeTabsuper', selectedTab);
                });
            });
        });
    </script>
@endsection
