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
                        <h3 class="fw-bold mb-3">Users</h3>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="filter-buttons mb-3">
                            <div class="d-flex">
                                <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                                    data-bs-target="#filter-database" data-button="published">
                                    Filter Category
                                </button>

                                <form id="dynamicFieldsContainer_published" action="{{ route('admin.guestAccount') }}"
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
                                            href="{{ route('download.pdf.user.admin') . '?' . http_build_query(['ids' => $guestAccounts->pluck('id')->toArray()]) }}">PDF</a>
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

                                        <div id="dynamic_status_container">
                                            <div class="select-wrapper">
                                                <label for="status_select">Status</label>
                                                <div class="input-group">
                                                    <select class="form-control dynamic_status_select"
                                                        aria-label="Select Status" name="status[]">
                                                        <option value="">Select Category</option>
                                                        <option value="Active">
                                                            Active</option>
                                                        <option value="Inactive">
                                                            Inactive</option>
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

                    <div class="card table-responsive">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="all-account-tab" data-bs-toggle="tab" href="#all-account"
                                        role="tab" aria-controls="all-account" aria-selected="false" data-tab="all">
                                        Users</a>
                                </li>

                                <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                    <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>
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
                                                        <th scope="col"><input type="checkbox" id="select-all"></th>
                                                        <th scope="col">#</th>
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
                                                                <td>
                                                                    <input type="checkbox" class="row-checkbox"
                                                                        id="select-all" value="{{ $guestAccount->id }}">
                                                                </td>
                                                                <td>{{ $counter++ }}</td>
                                                                <td>{{ $guestAccount->user_code }}</td>
                                                                <td>{{ $guestAccount->name }}</td>
                                                                <td>{{ $guestAccount->email }}</td>
                                                                <td>{{ $guestAccount->phone }}</td>
                                                                <td>{{ $guestAccount->birthday }}</td>
                                                                @if ($guestAccount->status === 'Active')
                                                                    @if ($guestAccount->account_status === 'active')
                                                                        <td><span
                                                                                class="badge fs-5 text-bg-success">{{ $guestAccount->status }}</span>
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                                @if ($guestAccount->status === 'Inactive')
                                                                    @if ($guestAccount->account_status === 'active')
                                                                        <td><span
                                                                                class="badge fs-5 text-bg-primary">{{ $guestAccount->status }}</span>
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                                @if ($guestAccount->account_status === 'blocked')
                                                                    <td><span
                                                                            class="badge fs-5 text-bg-danger">{{ $guestAccount->account_status }}</span>
                                                                    </td>
                                                                @endif

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

            const dynamicStatusContainer = document.getElementById('dynamic_status_container');
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

                processDynamicFields('.dynamic_status_select', 'Status');
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
                        fetch('/admin/guestAccount/delete', {
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
        });
    </script>

@endsection
