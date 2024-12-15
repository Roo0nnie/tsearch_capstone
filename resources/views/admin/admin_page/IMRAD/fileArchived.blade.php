@extends('layouts.admin')


@section('content')

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
            <div class="alert alert-danger bg-danger text-white">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Archived Files</h3>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-between">
                    <div class="filter-buttons">

                        <div class="d-flex">
                            <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                                data-bs-target="#filter-database_1" data-button="archive">
                                Filter Category
                            </button>

                            <form id="dynamicFieldsContainer_archive" action="{{ route('admin.file.archived') }}"
                                method="GET" class="d-flex">
                                @csrf
                                <div id="displayFields_archive" class="d-flex">

                                </div>
                                <button id="filterButton_archive" type="submit" class="btn btn-primary mx-2"
                                    style="display: none;">Apply</button>
                                <input type="hidden" name="filter_type" value="archive">
                            </form>
                        </div>

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="filter-database_1" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Archieve Files</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="filter_select_archive">

                                        <div id="dynamic_category_archive_container">
                                            <div class="select-wrapper">
                                                <label for="category_select_archive">Category</label>
                                                <div class="input-group">
                                                    <select class="form-control dynamic_category_archive_select"
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

                                        <div id="dynamic_adviser_archive_container">
                                            <div class="select-wrapper_archive">
                                                <label for="adviser_select_archive">Adviser</label>
                                                <div class="input-group">
                                                    <select class="form-control dynamic_adviser_archive_select"
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
                                        <div id="dynamic_course_archive_container">
                                            <div class="select-wrapper_archive mt-2">
                                                <label for="course_select_archive">Department</label>
                                                <div class="input-group">
                                                    <select class="form-control dynamic_course_archive_select"
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
                                        <div id="dynamic_sdg_container_archive">
                                            <div class="select-wrapper_archive mt-2">
                                                <label for="sdg_select_archive">SDG</label>
                                                <div class="input-group">
                                                    <select class="form-control dynamic_sdg_archive_select"
                                                        aria-label="Select SDG" name="SDG[]">
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

                                                            // Dynamically map the SDG numbers to the list for rendering.
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
                                            <!-- Start Year Section -->
                                            <div class="col-md-6">
                                                <label for="start_year_archive">From Year</label>
                                                <select id="start_year_archive"
                                                    class="dynamic_start_archive_select form-control" name="start_year">
                                                    <option value="">Select a Start Year</option>
                                                    @for ($year = 2010; $year <= 2024; $year++)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- End Year Section -->
                                            <div class="col-md-6">
                                                <label for="end_year_archive">To Year</label>
                                                <select id="end_year_archive"
                                                    class="dynamic_end_archive_select form-control" name="end_year">
                                                    <option value="">Select an End Year</option>
                                                    @for ($year = 2010; $year <= 2024; $year++)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <div class="text-center">
                                            <button type="button" id="applyButton_archive"
                                                class="btn btn-primary mt-2 text-center"
                                                data-bs-dismiss="modal">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown me-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Download
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('download.pdf.file.admin') . '?' . http_build_query(['ids' => $archives->pluck('id')->toArray()]) }}">PDF</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('download.excel.file.admin') . '?' . http_build_query(['ids' => $archives->pluck('id')->toArray()]) }}"">Excel</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="mt-3">
                <div class="card table-responsive">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="online-account-tab" data-bs-toggle="tab"
                                    href="#online-account" role="tab" aria-controls="online-account"
                                    aria-selected="false" data-tab="archive">Archive Files</a>
                            </li>

                            <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                <button id="archive-selected" type="button" class="btn-primary btn mb-2 ">Published
                                    File</button>
                                <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- Online Users Tab -->
                            <div class="" id="online-account" role="" aria-labelledby="online-account-tab">
                                <div class="container">


                                    <div id="imrad-table">
                                        <table id="file-datatables_2" class="display table table-striped table-hover">
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
                                                    <th scope="col">Publication Date</th>
                                                    <th scope="col">Call #</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="archive-table-body">
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($archives as $archive)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="row-checkbox" id="select-all"
                                                                value="{{ $archive->id }}">
                                                        </td>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $archive->category }}</td>
                                                        <td>{{ $archive->title }}</td>
                                                        <td>{{ Str::limit($archive->author, 50, '...') }}</td>
                                                        <td>{{ $archive->adviser }}</td>
                                                        <td>{{ $archive->department }}</td>
                                                        <td>{{ Str::limit($archive->abstract, 150, '...') }}</td>
                                                        <td>{{ $archive->publication_date }}</td>
                                                        <td>{{ $archive->location }}</td>
                                                        <td>
                                                            <div class="btn-group text-sm-center" role="group"
                                                                aria-label="Basic mixed styles example">

                                                                <a href="{{ route('admin.imrad.view', ['imrad' => $archive]) }}"
                                                                    class="btn btn-primary">View</a>

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

            // Archive table functionality
            const dynamicAdviser_archiveContainer = document.getElementById('dynamic_adviser_archive_container');
            const dynamicCategory_archiveContainer = document.getElementById('dynamic_adviser_category_container');
            const dynamicCourse_archiveContainer = document.getElementById('dynamic_course_archive_container');
            const dynamicSDG_archiveContainer = document.getElementById('dynamic_sdg_archive_container');
            const dynamicStart_archiveContainer = document.getElementById('dynamic_start_archive_container');
            const dynamicEnd_archiveContainer = document.getElementById('dynamic_end_archive_container');

            const dynamicFields_archiveContainer = document.getElementById('dynamicFieldsContainer_archive');
            const applyButton_archive = document.getElementById('applyButton_archive');

            const seenValues_archive = new Set();

            function handleApply() {
                let isValid_archive = true;

                const startYear_archiveField = document.querySelector('.dynamic_start_archive_select');
                const endYear_archiveField = document.querySelector('.dynamic_end_archive_select');

                const startYear_archive = startYear_archiveField ? startYear_archiveField.value.trim() : '';
                const endYear_archive = endYear_archiveField ? endYear_archiveField.value.trim() : '';

                // Validation: Ensure start year is less than or equal to end year
                if (startYear_archive && endYear_archive && parseInt(startYear_archive) > parseInt(
                        endYear_archive)) {
                    isValid_archive = false;
                    alert('Start Year should be less than or equal to End Year.');
                }

                if (!isValid_archive) return;

                const processDynamicFields = (selector_archive, label_archive) => {
                    const elements_archive = document.querySelectorAll(selector_archive);
                    elements_archive.forEach(select_archive => {
                        const value_archive = select_archive.value.trim();
                        if (value_archive && !seenValues_archive.has(value_archive)) {
                            seenValues_archive.add(value_archive);
                            const div_archive = createDynamicField(label_archive, value_archive);
                            const displayFields_archive = document.getElementById(
                                'displayFields_archive');
                            displayFields_archive.appendChild(div_archive);
                        }
                    });
                };

                processDynamicFields('.dynamic_adviser_archive_select', 'Adviser');
                processDynamicFields('.dynamic_category_archive_select', 'Category');
                processDynamicFields('.dynamic_course_archive_select', 'Department');
                processDynamicFields('.dynamic_sdg_archive_select', 'SDG');
                processDynamicFields('.dynamic_start_archive_select', 'Start Year');
                processDynamicFields('.dynamic_end_archive_select', 'End Year');
            }

            function createDynamicField(type, value) {
                const div_archive = document.createElement('div');
                div_archive.classList.add('dynamicField_archive');
                div_archive.innerHTML = `
                    <div class="input-group d-flex align-items-center">
                        <span class="input-group-text_archive me-2">${type}</span>
                        <input type="text" value="${value}" readonly class="form-control dynamicInput_archive" name="${type.toLowerCase().replace(' ', '_')}[]">
                        <button type="button" class="btn btn-outline-secondary deleteButton_archive">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                `;

                const hiddenInput_archive = document.createElement('input');
                hiddenInput_archive.type = 'hidden';
                hiddenInput_archive.name = type.toLowerCase().replace(' ', '_') + '[]';
                hiddenInput_archive.value = value;

                const displayFields_archive = document.getElementById('displayFields_archive');
                displayFields_archive.appendChild(hiddenInput_archive);

                div_archive.querySelector('.deleteButton_archive').addEventListener('click', () => {
                    seenValues_archive.delete(value);
                    div_archive.remove();
                    hiddenInput_archive.remove();
                    showFilterButton();
                });

                showFilterButton();

                return div_archive;
            }

            function showFilterButton() {
                const filterButton = document.getElementById('filterButton_archive');
                const displayFields = document.getElementById('displayFields_archive');

                if (displayFields.children.length > 0) {
                    filterButton.style.display = 'block';
                } else {
                    filterButton.style.display = 'none';
                }
            }

            document.getElementById('applyButton_archive').addEventListener('click', handleApply);

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
                    text: "You are about to publish the selected items. This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/bulk-published', {
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
                                Swal.fire("Published!",
                                    "The selected items have been published.",
                                    "success");
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error archiving:', error);
                                Swal.fire("Error!",
                                    "An error occurred while publishing the items.", "error"
                                );
                            });
                    }
                });
            });

        });
    </script>

@endsection
