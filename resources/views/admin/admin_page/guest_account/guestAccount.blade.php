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
                        <h3 class="fw-bold mb-3">Users</h3>
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
                                        Users</a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="online-account-tab" data-bs-toggle="tab" href="#online-account"
                                        role="tab" aria-controls="online-account" aria-selected="false"
                                        data-tab="online">Active
                                        Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="offline-account-tab" data-bs-toggle="tab"
                                        href="#offline-account" role="tab" aria-controls="offline-account"
                                        aria-selected="false" data-tab="offline">Inactive Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="invalid-account-tab" data-bs-toggle="tab"
                                        href="#invalid-account" role="tab" aria-controls="invalid-account"
                                        aria-selected="false" data-tab="invalid">Blocked Users</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content mt-3">
                                <!-- All Users Tab -->
                                <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                    aria-labelledby="all-account-tab">
                                    <div class="container">
                                        <div id="faculty-table">
                                            <table id="basic-datatables" class="display table table-striped table-hover ">
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
                                                <tbody id="guest-table-body">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($guestAccounts as $guestAccount)
                                                        @if ($guestAccount->action !== 'deleted')
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td>{{ $guestAccount->user_code }}</td>
                                                                <td>{{ $guestAccount->name }}</td>
                                                                <td>{{ $guestAccount->email }}</td>
                                                                <td>{{ $guestAccount->phone }}</td>
                                                                <td>{{ $guestAccount->birthday }}</td>
                                                                <td>{{ $guestAccount->status }}</td>
                                                                <td>
                                                                    <div class="btn-group text-sm-center" role="group"
                                                                        aria-label="Basic mixed styles example">

                                                                        <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                            class="btn-primary btn">Edit</a>

                                                                        <button
                                                                            class="btn btn-outline-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="actionDropdown{{ $guestAccount->id }}"
                                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">

                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="actionDropdown{{ $guestAccount->id }}">
                                                                            <li><a href="{{ route('admin.guestAccount.view', ['guestAccount' => $guestAccount]) }}"
                                                                                    class="dropdown-item">View</a>
                                                                            </li>
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
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

                                <!-- Online Users Tab -->
                                <div class="tab-pane fade" id="online-account" role="tabpanel"
                                    aria-labelledby="online-account-tab">
                                    <div class="container">

                                        <div>
                                            <div id="faculty_table">
                                                <table id="basic-datatables_2"
                                                    class="display table table-striped table-hover ">
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
                                                    <tbody id="guest-active-table-body">
                                                        @php
                                                            $counter = 1;
                                                        @endphp
                                                        @foreach ($guestAccounts as $guestAccount)
                                                            @if ($guestAccount->status === 'Active' && $guestAccount->action !== 'deleted')
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>{{ $guestAccount->user_code }}</td>
                                                                    <td>{{ $guestAccount->name }}</td>
                                                                    <td>{{ $guestAccount->email }}</td>
                                                                    <td>{{ $guestAccount->phone }}</td>
                                                                    <td>{{ $guestAccount->birthday }}</td>
                                                                    <td>{{ $guestAccount->status }}</td>
                                                                    <td>
                                                                        <div class="btn-group text-sm-center"
                                                                            role="group"
                                                                            aria-label="Basic mixed styles example">

                                                                            <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                                class="btn-primary btn">Edit</a>

                                                                            <button
                                                                                class="btn btn-outline-secondary dropdown-toggle"
                                                                                type="button"
                                                                                id="actionDropdown{{ $guestAccount->id }}"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">

                                                                            </button>
                                                                            <ul class="dropdown-menu"
                                                                                aria-labelledby="actionDropdown{{ $guestAccount->id }}">
                                                                                <li><a class="dropdown-item"
                                                                                        {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                                                        href="">View</a>
                                                                                </li>
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                                        method="POST"
                                                                                        style="display:inline;">
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

                                <!-- Invalid Users Tab -->
                                <div class="tab-pane fade" id="offline-account" role="tabpanel"
                                    aria-labelledby="offline-account-tab">
                                    <!-- Content for Invalid Users Tab -->
                                    <div class="container">


                                        <div class="">
                                            <div>
                                                <div id="">
                                                    <table id="basic-datatables_3"
                                                        class="display table table-striped table-hover ">
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
                                                        <tbody id="guest-inactive-table-body">
                                                            @php
                                                                $counter = 1;
                                                            @endphp
                                                            @foreach ($guestAccounts as $guestAccount)
                                                                @if ($guestAccount->status === 'Inactive' && $guestAccount->action !== 'deleted')
                                                                    <tr>
                                                                        <td>{{ $counter++ }}</td>
                                                                        <td>{{ $guestAccount->user_code }}</td>
                                                                        <td>{{ $guestAccount->name }}</td>
                                                                        <td>{{ $guestAccount->email }}</td>
                                                                        <td>{{ $guestAccount->phone }}</td>
                                                                        <td>{{ $guestAccount->birthday }}</td>
                                                                        <td>{{ $guestAccount->status }}</td>
                                                                        <td>

                                                                            <div class="btn-group text-sm-center"
                                                                                role="group"
                                                                                aria-label="Basic mixed styles example">

                                                                                <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                                    class="btn-primary btn">Edit</a>

                                                                                <button
                                                                                    class="btn btn-outline-secondary dropdown-toggle"
                                                                                    type="button"
                                                                                    id="actionDropdown{{ $guestAccount->id }}"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">

                                                                                </button>
                                                                                <ul class="dropdown-menu"
                                                                                    aria-labelledby="actionDropdown{{ $guestAccount->id }}">
                                                                                    <li><a class="dropdown-item"
                                                                                            {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                                                            href="">View</a>
                                                                                    </li>
                                                                                    <li>
                                                                                        <form
                                                                                            action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                                            method="POST"
                                                                                            style="display:inline;">
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


                                <div class="tab-pane fade" id="invalid-account" role="tabpanel"
                                    aria-labelledby="invalid-account-tab">
                                    <!-- Content for Invalid Users Tab -->
                                    <div class="container">

                                        <div id="faculty_table">
                                            <table id="basic-datatables_4"
                                                class="display table table-striped table-hover">
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
                                                <tbody id="guest-active-table-body">
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($guestAccounts as $guestAccount)
                                                        @if ($guestAccount->account_status === 'blocked' && $guestAccount->action !== 'deleted')
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td>{{ $guestAccount->user_code }}</td>
                                                                <td>{{ $guestAccount->name }}</td>
                                                                <td>{{ $guestAccount->email }}</td>
                                                                <td>{{ $guestAccount->phone }}</td>
                                                                <td>{{ $guestAccount->birthday }}</td>
                                                                <td>{{ $guestAccount->account_status }}</td>
                                                                <td>

                                                                    <div class="btn-group text-sm-center" role="group"
                                                                        aria-label="Basic mixed styles example">

                                                                        <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                            class="btn-primary btn">Edit</a>

                                                                        <button
                                                                            class="btn btn-outline-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="actionDropdown{{ $guestAccount->id }}"
                                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">

                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="actionDropdown{{ $guestAccount->id }}">
                                                                            <li><a class="dropdown-item"
                                                                                    {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                                                    href="">View</a>
                                                                            </li>
                                                                            <li>

                                                                                <form
                                                                                    action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                                    method="POST"
                                                                                    style="display:inline;">
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
            let activeTab = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTab) {
                activeTab = localStorage.getItem('activeTab') || 'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTab}"]`);
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
                    localStorage.setItem('activeTab', selectedTab);
                });
            });
        });
    </script>

@endsection
