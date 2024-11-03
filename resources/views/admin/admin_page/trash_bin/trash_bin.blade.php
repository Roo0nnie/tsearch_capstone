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

            @if (session('error'))
                <div class="alert alert-danger">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Trash</h3>

                    </div>

                </div>

                <div class="mt-3">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="all-account-tab" data-bs-toggle="tab" href="#all-account"
                                        role="tab" aria-controls="all-account" aria-selected="false"
                                        data-tab="all">Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="online-account-tab" data-bs-toggle="tab" href="#online-account"
                                        role="tab" aria-controls="online-account" aria-selected="false"
                                        data-tab="online">Files</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content mt-3">
                                <!-- All Users Tab -->
                                <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                    aria-labelledby="all-account-tab">
                                    <div class="container">
                                        <div>
                                            <div id="imrad-table">
                                                <table id="userDeleted-datatables_1"
                                                    class="display table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Role</th>
                                                            <th scope="col">Deleted On</th>
                                                            <th scope="col">Deleted By</th>
                                                            <th scope="col">Scheduled Deletion</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="user-table-body">
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @foreach ($users as $user)
                                                            <tr data-id="{{ $user->id }}">
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $user->user_code }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->type }}</td>
                                                                <td>{{ $user->deleted_time }}</td>
                                                                <td>{{ $user->delete_by }}</td>
                                                                <td class="scheduled-deletion">
                                                                    {{ $user->permanent_delete }}
                                                                </td>
                                                                <td>

                                                                    <div class="btn-group text-sm-center" role="group"
                                                                        aria-label="Basic mixed styles example">

                                                                        <a href="{{ route('admin.user.recover', ['user' => $user]) }}"
                                                                            class="btn-primary btn">Recover</a>

                                                                        <button
                                                                            class="btn btn-outline-secondary dropdown-toggle"
                                                                            type="button"
                                                                            id="actionDropdown{{ $user->id }}"
                                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">

                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="actionDropdown{{ $user->id }}">
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('admin.user.destroy', ['user' => $user]) }}"
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
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Online Users Tab -->
                                <div class="tab-pane fade" id="online-account" role="tabpanel"
                                    aria-labelledby="online-account-tab">
                                    <div class="container">


                                        <div id="imrad-table">
                                            <table id="fileDeleted-datatables_1"
                                                class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Deleted On</th>
                                                        <th scope="col">Deleted By</th>
                                                        <th scope="col">Scheduled Deletion</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="archive-table-body">
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($archives as $archive)
                                                        <tr data-id="{{ $archive->id }}">
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $archive->title }}</td>
                                                            <td>{{ $archive->deleted_time }}</td>
                                                            <td>{{ $archive->delete_by }}</td>
                                                            <td class="scheduled-deletion">
                                                                {{ $archive->permanent_delete }}
                                                            </td>
                                                            <td>

                                                                <div class="btn-group text-sm-center" role="group"
                                                                    aria-label="Basic mixed styles example">

                                                                    <a href="{{ route('admin.archive.recover', ['archive' => $archive]) }}"
                                                                        class="btn-primary btn">Recover</a>

                                                                    <button
                                                                        class="btn btn-outline-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="actionDropdown{{ $archive->id }}"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">

                                                                    </button>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="actionDropdown{{ $archive->id }}">
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.trash-bin.delete', ['archive' => $archive]) }}"
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
        function updateDeletionTimers() {
            const now = new Date();

            // Handle user deletion timers
            document.querySelectorAll('.scheduled-deletion').forEach((element) => {
                const row = element.closest('tr');
                const userId = row.dataset.id;
                const deletionTimeString = element.textContent.trim();
                const deletionTime = new Date(deletionTimeString);

                if (isNaN(deletionTime.getTime())) {
                    console.log(`Invalid deletion date for user ID: ${userId}`);
                    return;
                }

                const timeRemaining = deletionTime - now;

                if (timeRemaining > 0) {
                    const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                    console.log(
                        `User ID ${userId}: Time remaining until deletion: ${hours}h ${minutes}m ${seconds}s`);
                } else {
                    console.log(`User ID ${userId}: Time to delete.`);
                    deleteUser(userId, row);
                }
            });

            // Handle archive deletion timers
            document.querySelectorAll('#archive-table-body .scheduled-deletion').forEach((element) => {
                const row = element.closest('tr');
                const archiveId = row.dataset.id;
                const deletionTimeString = element.textContent.trim();
                const deletionTime = new Date(deletionTimeString);

                if (isNaN(deletionTime.getTime())) {
                    console.log(`Invalid deletion date for archive ID: ${archiveId}`);
                    return;
                }

                const timeRemaining = deletionTime - now;

                if (timeRemaining > 0) {
                    const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                    console.log(
                        `Archive ID ${archiveId}: Time remaining until deletion: ${hours}h ${minutes}m ${seconds}s`
                    );
                } else {
                    console.log(`Archive ID ${archiveId}: Time to delete.`);
                    deleteArchive(archiveId, row);
                }
            });
        }

        function deleteUser(userId, row) {
            fetch(`{{ url('/admin/trash-destroy/') }}/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        row.remove();
                        console.log(`User ID ${userId} deleted.`);
                    } else {
                        console.error(`Failed to delete user ID ${userId}.`);
                    }
                });
        }

        function deleteArchive(archiveId, row) {
            fetch(`{{ url('/admin/trash-destroy/imrad/') }}/${archiveId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        row.remove();
                        console.log(`Archive ID ${archiveId} deleted.`);
                    } else {
                        console.error(`Failed to delete archive ID ${archiveId}.`);
                    }
                });
        }

        setInterval(updateDeletionTimers, 1000);

        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabDeleted = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabDeleted) {
                activeTabDeleted = localStorage.getItem('activeTabDeleted') || 'all'; // Default to 'all' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabDeleted}"]`);
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
                    localStorage.setItem('activeTabDeleted', selectedTab);
                });
            });
        });
    </script>

@endsection
