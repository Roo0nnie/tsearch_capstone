@extends('layouts.admin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
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

        @if (session('error_format'))
            <script>
                Swal.fire({
                    title: 'Error Format',
                    html: `
<div class="d-flex flex-column justify-content-center align-items-center text-center">
            <div>Click the file format below.</div>
            <div>
                <a href="{{ asset('assets/file_format/sample_format.pdf') }}" target="_blank" class="btn"
                    data-pdf-url="{{ asset('file_format/sample_format.pdf') }}">
                    <h4>File Format</h4>
                </a>
            </div>
        </div>
                `,
                    icon: 'error'
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                Swal.fire({
                    title: 'Error!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Published Files</h3>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="filter-buttons">
                    <div class="d-flex">
                        <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                            data-bs-target="#filter-database" data-button="published">
                            Filter Category
                        </button>

                        <form id="dynamicFieldsContainer_published" action="{{ route('admin.file.published') }}"
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

                <div>
                    <div class="d-flex flex-col">
                        <div class="dropdown me-3">
                            <button class="btn btn-maroon dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Add File
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="triggerFileUpload()">Auto File
                                        Input</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.imrad.manual.add') }}">Manual File
                                        Input</a>
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Download
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('download.pdf.file.admin') . '?' . http_build_query(['ids' => $imrads->pluck('id')->toArray()]) }}">PDF</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('download.excel.file.admin') . '?' . http_build_query(['ids' => $imrads->pluck('id')->toArray()]) }}"">Excel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form id="file-upload-form" action="{{ route('admin.imrad.create') }}" method="POST"
                        enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="file-input" accept="pdf" name="file"
                            onchange="submitFileUploadForm()" required>
                    </form>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Published Files</h1>
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

                                    <!-- Adviser Section -->
                                    <div id="dynamic_adviser_container" class="mt-2">
                                        <div class="select-wrapper">
                                            <label for="adviser_select">Adviser</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_adviser_select"
                                                    aria-label="Select Adviser" name="adviser[]">
                                                    <option value="">Select Adviser</option>
                                                    @foreach ($adviserList as $adviser)
                                                        <option value="{{ $adviser }}">{{ $adviser }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Course Section -->
                                    <div id="dynamic_course_container">
                                        <div class="select-wrapper mt-2">
                                            <label for="course_select">Department</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_course_select"
                                                    aria-label="Select Course" name="department[]">
                                                    <option value="">Select Course</option>
                                                    @foreach ($departmentList as $department)
                                                        <option value="{{ $department }}">{{ $department }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SDG Section -->
                                    <div id="dynamic_sdg_container">
                                        <div class="select-wrapper mt-2">
                                            <label for="sdg_select">SDG</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_sdg_select" aria-label="Select SDG"
                                                    name="SDG[]">
                                                    <option value="">Select SDG</option>

                                                    @php
                                                        $SDGMapping = [
                                                            1 => 'No Poverty',
                                                            2 => 'Zero Hunger',
                                                            3 => 'Good Health and Well-being',
                                                            4 => 'Quality Education',
                                                            5 => 'Gender Equality',
                                                            6 => 'Clean Water and Sanitation',
                                                            7 => 'Affordable and Clean Energy',
                                                            8 => 'Decent Work and Economic Growth',
                                                            9 => 'Industry, Innovation, and Infrastructure',
                                                            10 => 'Reduced Inequalities',
                                                            11 => 'Sustainable Cities and Communities',
                                                            12 => 'Responsible Consumption and Production',
                                                            13 => 'Climate Action',
                                                            14 => 'Life Below Water',
                                                            15 => 'Life on Land',
                                                            16 => 'Peace, Justice, and Strong Institutions',
                                                            17 => 'Partnerships for the Goals',
                                                        ];

                                                        $SDGList = [];
                                                        foreach ($SDGMapping as $key => $name) {
                                                            $SDGList[$key] = $name;
                                                        }

                                                    @endphp
                                                    @foreach ($SDGList as $sdgNumber => $name)
                                                        <option value="{{ $sdgNumber }}">{{ $sdgNumber }}.
                                                            {{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <!-- Start Create Section -->
                                        <div class="col-md-6">
                                            <label for="start_create">From Create</label>
                                            <input type="date" id="start_create"
                                                class="dynamic_start_create_select form-control" name="start_create">
                                        </div>

                                        <!-- End Create Section -->
                                        <div class="col-md-6">
                                            <label for="end_create">To Create</label>
                                            <input type="date" id="end_create"
                                                class="dynamic_end_create_select form-control" name="end_create">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <!-- Start Year Section -->
                                        <div class="col-md-6">
                                            <label for="start_year">From Year</label>
                                            <select id="start_year" class="dynamic_start_select form-control"
                                                name="start_year">
                                                <option value="">Select a Start Year</option>
                                                @for ($year = 2010; $year <= 2024; $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- End Year Section -->
                                        <div class="col-md-6">
                                            <label for="end_year">To Year</label>
                                            <select id="end_year" class="dynamic_end_select form-control"
                                                name="end_year">
                                                <option value="">Select an End Year</option>
                                                @for ($year = 2010; $year <= 2024; $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
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

            </div>

            <div class="mt-3">
                <div class="card table-responsive">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-account-tab" data-bs-toggle="tab" href="#all-account"
                                    role="tab" aria-controls="all-account" aria-selected="false"
                                    data-tab="published">Published Files</a>
                            </li>

                            <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                <button id="archive-selected" type="button" class="btn-primary btn mb-2 ">Archive
                                    File</button>
                                <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </ul>

                        <div class="tab-content mt-3">
                            <div class="tab-pane show active fade" id="all-account" role="tabpanel"
                                aria-labelledby="all-account-tab">
                                <div class="container">
                                    <div id="imrad-table">
                                        <table id="file-datatables_1" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><input type="checkbox" id="select-all"></th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Author</th>
                                                    <th scope="col">Adviser</th>
                                                    <th scope="col">Department</th>
                                                    <th scope="col">Abstract</th>
                                                    <th scope="col">Year</th>
                                                    <th scope="col">Call #</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="imrad-table-body">
                                                @php $count = 1; @endphp
                                                @foreach ($imrads as $imrad)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="row-checkbox" id="select-all"
                                                                value="{{ $imrad->id }}">
                                                        </td>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $imrad->category }}</td>
                                                        <td>{{ $imrad->title }}</td>
                                                        <td>{{ Str::limit($imrad->author, 50, '...') }}</td>
                                                        <td>{{ $imrad->adviser }}</td>
                                                        <td>{{ $imrad->department }}</td>
                                                        <td>{{ Str::limit($imrad->abstract, 150, '...') }}</td>
                                                        <td>{{ $imrad->publication_date }}</td>
                                                        <td>{{ $imrad->location }}</td>
                                                        <td>

                                                            <div class="btn-group text-sm-center" role="group"
                                                                aria-label="Basic mixed styles example">

                                                                <button class="btn btn-outline-secondary dropdown-toggle"
                                                                    type="button" id="actionDropdown{{ $imrad->id }}"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">

                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="actionDropdown{{ $imrad->id }}">
                                                                    <li><a href="{{ route('admin.imrad.view', ['imrad' => $imrad]) }}"
                                                                            class="dropdown-item">View</a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="{{ route('admin.imrad.edit', ['imrad' => $imrad]) }}"
                                                                            class="dropdown-item archive-link"
                                                                            data-id="{{ $imrad->id }}">Edit</a>
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
        document.addEventListener('DOMContentLoaded', function() {

            const dynamicAdviserContainer = document.getElementById('dynamic_adviser_container');
            const dynamicCategoryContainer = document.getElementById('dynamic_category_container');
            const dynamicCourseContainer = document.getElementById('dynamic_course_container');
            const dynamicSDGContainer = document.getElementById('dynamic_sdg_container');
            const dynamicStartContainer = document.getElementById('dynamic_start_container');
            const dynamicEndContainer = document.getElementById('dynamic_end_container');

            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer_published');
            const applyButton = document.getElementById('applyButton');

            const seenValues = new Set();

            function handleApply() {
                let isValid = true;

                const startYearField = document.querySelector('.dynamic_start_select');
                const endYearField = document.querySelector('.dynamic_end_select');
                const startCreateField = document.querySelector('.dynamic_start_create_select');
                const endCreateField = document.querySelector('.dynamic_end_create_select');

                const startYear = startYearField ? startYearField.value.trim() : '';
                const endYear = endYearField ? endYearField.value.trim() : '';

                const startCreate = startCreateField ? startCreateField.value.trim() : '';
                const endCreate = endCreateField ? endCreateField.value.trim() : '';

                // Validation: Ensure start year is less than or equal to end year
                if (startYear && endYear && parseInt(startYear) > parseInt(endYear)) {
                    isValid = false;
                    alert('Start Year should be less than or equal to End Year.');
                }

                if (startCreate && endCreate && new Date(startCreate) > new Date(endCreate)) {
                    isValid = false;
                    alert('Start Create Date should be less than or equal to End Create Date.');
                }

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

                processDynamicFields('.dynamic_adviser_select', 'Adviser');
                processDynamicFields('.dynamic_category_select', 'Category');
                processDynamicFields('.dynamic_course_select', 'Department');
                processDynamicFields('.dynamic_sdg_select', 'SDG');
                processDynamicFields('.dynamic_start_select', 'Start_year');
                processDynamicFields('.dynamic_end_select', 'End_year');
                processDynamicFields('.dynamic_start_create_select', 'Start_create');
                processDynamicFields('.dynamic_end_create_select', 'End_create');
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
                        fetch('/admin/bulk-delete', {
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
                        fetch('/admin/bulk-archive', {
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
                                Swal.fire("Archived!", "The selected items have been archived.",
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

        // Trigger file upload dialog
        function triggerFileUpload() {
            document.getElementById('file-input').click();
        }

        // Submit the form once a file is selected
        function submitFileUploadForm() {
            const fileInput = document.getElementById('file-input');
            if (fileInput.files.length > 0) {
                document.getElementById('file-upload-form').submit();
            }
        }
    </script>
@endsection
