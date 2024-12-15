@extends('layouts.admin')


@section('content')

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
                        <h3 class="fw-bold mb-3">Deleted User</h3>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Download
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('download.pdf.deleteduser.admin') . '?' . http_build_query(['ids' => $users->pluck('id')->toArray()]) }}">PDF</a>
                            </li>
                        </ul>
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

                                <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                    <button id="archive-selected" type="button" class="btn-primary btn mb-2 ">Recover
                                        Users</button>
                                    <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content mt-3">
                                <!-- All Users Tab -->
                                <div class="tab-pane active" id="all-account" role="tabpanel"
                                    aria-labelledby="all-account-tab">
                                    <div class="container">
                                        <div>
                                            <div id="imrad-table">
                                                <table id="userDeleted-datatables_1"
                                                    class="display table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"><input type="checkbox" id="select-all"></th>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Deleted On</th>
                                                            <th scope="col">Deleted By</th>
                                                            <th scope="col">Scheduled Deletion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="user-table-body">
                                                        @php
                                                            $count = 1;
                                                        @endphp
                                                        @foreach ($users as $user)
                                                            <tr data-id="{{ $user->id }}">
                                                                <td>
                                                                    <input type="checkbox" class="row-checkbox"
                                                                        id="select-all" value="{{ $user->id }}">
                                                                </td>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $user->user_code }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->deleted_time }}</td>
                                                                <td>{{ $user->delete_by }}</td>
                                                                <td class="scheduled-deletion">
                                                                    {{ $user->permanent_delete }}
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
    </div>


    <script>
        function updateDeletionTimers() {
            const now = new Date();

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

                } else {
                    console.log(`User ID ${userId}: Time to delete.`);
                    deleteUser(userId, row);
                }
            });

            document.querySelectorAll('#archive-table-body .scheduled-deletion').forEach((element) => {
                const row = element.closest('tr');
                const archiveId = row.dataset.id;
                const deletionTimeString = element.textContent.trim();
                const deletionTime = new Date(deletionTimeString);

                if (isNaN(deletionTime.getTime())) {
                    return;
                }

                const timeRemaining = deletionTime - now;

                if (timeRemaining > 0) {

                    const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
                } else {
                    deleteArchive(archiveId, row);
                }
            });
        }

        function deleteUser(userId, row) {
            fetch(`{{ url('/admin/trash-destroy/auto/') }}/${userId}`, {
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



        setInterval(updateDeletionTimers, 1000);


        document.addEventListener('DOMContentLoaded', function() {
            // Select all checkbox
            const selectAllCheckbox = document.getElementById("select-all");
            const rowCheckboxes = document.querySelectorAll(".row-checkbox");
            const bulkActionButtons = document.getElementById("bulk-action-buttons");

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

            document.getElementById("delete-selected").addEventListener("click", () => {
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
                    text: "You are about to delete the selected items. This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/trash-destroy', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({
                                    ids: selectedIds,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire("Deleted!", data.message, "success");
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error deleting items:', error);
                                Swal.fire("Error!",
                                    "An error occurred while deleting the items.", "error");
                            });
                    }
                });
            });


            document.getElementById("archive-selected").addEventListener("click", () => {
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
                    text: "You are about to recover the selected items. This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/trash-bin', {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                                body: JSON.stringify({
                                    ids: selectedIds,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                Swal.fire("Recovered!",
                                    "The selected items have been recovered.",
                                    "success");
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error recovering:', error);
                                Swal.fire("Error!",
                                    "An error occurred while recovering the items.", "error"
                                );
                            });
                    }
                });
            });

        });
    </script>

@endsection
