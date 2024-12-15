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
                        <h3 class="fw-bold mb-3">Deleted File</h3>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="filter-buttons mb-3">
                        <div class="d-flex">
                            <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                                data-bs-target="#filter-database" data-button="published">
                                Filter Category
                            </button>

                            <form id="dynamicFieldsContainer_published" action="{{ route('admin.trash-file') }}"
                                method="GET" class="d-flex">
                                @csrf
                                <div id="displayFields" class="d-flex">

                                </div>
                                <button id="filterButton" type="submit" class="btn btn-primary mx-2"
                                    style="display: none;">Apply</button>
                                <input type="hidden" name="filter_type" value="published">
                            </form>
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
                                        href="{{ route('download.pdf.deletedfile.admin') . '?' . http_build_query(['ids' => $archives->pluck('id')->toArray()]) }}">PDF</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="" id="filter_select">

                                    <div id="dynamic_category_container">
                                        <div class="select-wrapper">
                                            <label for="category_select">Category</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_category_select"
                                                    aria-label="Select Category" name="category[]">
                                                    <option value="">Select Category</option>
                                                    <option value="Technology">
                                                        Technology</option>
                                                    <option value="Midwifery">
                                                        Midwifery</option>
                                                    <option value="Engineering">
                                                        Engineering</option>
                                                    <option value="Architecture">
                                                        Architecture</option>
                                                    <option value="Accountancy">
                                                        Accountancy</option>
                                                    <option value="Other">
                                                        Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Apply Button -->
                                    <div class="text-center">
                                        <button type="button" id="applyButton" class="btn btn-primary mt-2 text-center"
                                            data-bs-dismiss="modal">Apply</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="online-account-tab" data-bs-toggle="tab" href="#online-account"
                                        role="tab" aria-controls="online-account" aria-selected="false"
                                        data-tab="online">Files</a>
                                </li>

                                <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                    <button id="archive-selected" type="button" class="btn-primary btn mb-2 ">Recover
                                        Files</button>
                                    <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content mt-3">

                                <!-- Online Users Tab -->
                                <div class="tab-pane active" id="online-account" role="tabpanel"
                                    aria-labelledby="online-account-tab">
                                    <div class="container">


                                        <div id="imrad-table">
                                            <table id="fileDeleted-datatables_1"
                                                class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"><input type="checkbox" id="select-all"></th>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Category</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Deleted On</th>
                                                        <th scope="col">Deleted By</th>
                                                        <th scope="col">Scheduled Deletion</th>
                                                        {{-- <th scope="col">Actions</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="archive-table-body">
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($archives as $archive)
                                                        <tr data-id="{{ $archive->id }}">
                                                            <td>
                                                                <input type="checkbox" class="row-checkbox"
                                                                    id="select-all" value="{{ $archive->id }}">
                                                            </td>
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $archive->category }}</td>
                                                            <td>{{ $archive->title }}</td>
                                                            <td>{{ $archive->deleted_time }}</td>
                                                            <td>{{ $archive->delete_by }}</td>
                                                            <td class="scheduled-deletion">
                                                                {{ $archive->permanent_delete }}
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

        function deleteArchive(userId, row) {
            fetch(`{{ url('/admin/trash-destroy/imrad/') }}/${userId}`, {
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

            const dynamicCategoryContainer = document.getElementById('dynamic_category_container');
            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer_published');
            const applyButton = document.getElementById('applyButton');

            const seenValues = new Set();

            function handleApply() {
                let isValid = true;

                if (!isValid) return;

                const processDynamicFields = (selector, label) => {
                    const elements = document.querySelectorAll(selector);
                    elements.forEach(select => {
                        const value = select.value.trim();
                        if (value && !seenValues.has(value)) {
                            seenValues.add(value);
                            const div = createDynamicField(label, value);
                            const displayFields = document.getElementById('displayFields');
                            displayFields.appendChild(div);
                        }
                    });
                };

                processDynamicFields('.dynamic_category_select', 'Category');
            }

            function createDynamicField(type, value) {
                const div = document.createElement('div');
                div.classList.add('dynamicField');
                div.innerHTML = `
                    <div class="input-group d-flex align-items-center">
                            <span class="me-2">${type}</span>
                            <input type="text" value="${value}" readonly class="dynamicInput form-control" name="${type.toLowerCase().replace(' ', '_')}[]">
                            <button type="button" class="deleteButton btn btn-outline-secondary">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = type.toLowerCase().replace(' ', '_') + '[]';
                hiddenInput.value = value;

                const displayFields = document.getElementById('displayFields');
                displayFields.appendChild(hiddenInput);

                div.querySelector('.deleteButton').addEventListener('click', () => {
                    seenValues.delete(value);
                    div.remove();
                    hiddenInput.remove();

                    showFilterButton();
                });

                showFilterButton();

                return div;
            }

            function showFilterButton() {
                const filterButton = document.getElementById('filterButton');
                const displayFields = document.getElementById('displayFields');

                if (displayFields.children.length > 0) {
                    filterButton.style.display = 'block';
                } else {
                    filterButton.style.display = 'none';
                }
            }

            document.getElementById('applyButton').addEventListener('click', handleApply);


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
                        fetch('/admin/trash-destroy/imrad/select/delete', {
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
                    text: "You are about to archive the selected items. This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/recover/', {
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
                                Swal.fire("Recover!", "The selected items have been archived.",
                                    "success");
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error archiving:', error);
                                Swal.fire("Error!",
                                    "An error occurred while archiving the items.", "error");
                            });
                    }
                });
            });

        });
    </script>

@endsection
