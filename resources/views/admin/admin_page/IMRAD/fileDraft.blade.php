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
                    <h3 class="fw-bold mb-3">Draft Files</h3>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="filter-buttons">
                    <div class="d-flex">
                        <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                            data-bs-target="#filter-database_1" data-button="draft">
                            Filter Category
                        </button>

                        <form id="dynamicFieldsContainer_draft" action="{{ route('admin.file.draft') }}" method="GET"
                            class="d-flex">
                            @csrf
                            <div id="displayFields_draft" class="d-flex">

                            </div>
                            <button id="filterButton_draft" type="submit" class="btn btn-primary mx-2"
                                style="display: none;">Apply</button>
                            <input type="hidden" name="filter_type" value="draft">
                        </form>
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
                                    href="{{ route('download.pdf.file.draft') . '?' . http_build_query(['ids' => $tempfiles->pluck('id')->toArray()]) }}">PDF</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('download.excel.file.draft') . '?' . http_build_query(['ids' => $tempfiles->pluck('id')->toArray()]) }}">Excel</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database_1" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter draft Files</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="filter_select_draft">

                                    <div id="dynamic_category_draft_container">
                                        <div class="select-wrapper">
                                            <label for="category_select_draft">Category</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_category_draft_select"
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

                                    <div id="dynamic_adviser_draft_container">
                                        <div class="select-wrapper_draft">
                                            <label for="adviser_select_draft">Adviser</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_adviser_draft_select"
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
                                    <div id="dynamic_course_draft_container">
                                        <div class="select-wrapper_draft mt-2">
                                            <label for="course_select_draft">Department</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_course_draft_select"
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
                                    <div id="dynamic_sdg_container_draft">
                                        <div class="select-wrapper_draft mt-2">
                                            <label for="sdg_select_draft">SDG</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_sdg_draft_select"
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
                                            <label for="start_year_draft">From Year</label>
                                            <select id="start_year_draft" class="dynamic_start_draft_select form-control"
                                                name="start_year">
                                                <option value="">Select a Start Year</option>
                                                @for ($year = 2010; $year <= 2024; $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- End Year Section -->
                                        <div class="col-md-6">
                                            <label for="end_year_draft">To Year</label>
                                            <select id="end_year_draft" class="dynamic_end_draft_select form-control"
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
                                        <button type="button" id="applyButton_draft"
                                            class="btn btn-primary mt-2 text-center"
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
                                <a class="nav-link active" id="online-account-tab" data-bs-toggle="tab"
                                    href="#online-account" role="tab" aria-controls="online-account"
                                    aria-selected="false" data-tab="draft">Draft Files</a>
                            </li>

                            <div id="bulk-action-buttons" style="display: none; padding-left:10px;">
                                <button id="delete-selected" type="button" class="btn-maroon btn mb-2"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- Online Users Tab -->
                            <div class="" id="online-account" role="" aria-labelledby="online-account-tab">
                                <div class="container">

                                    <div id="imrad-table">
                                        <table id="file-datatables_3" class="display table table-striped table-hover">
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
                                            <tbody id="temp-table-body">
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($tempfiles as $tempfile)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="row-checkbox" id="select-all"
                                                                value="{{ $tempfile->id }}">
                                                        </td>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $tempfile->category }}</td>
                                                        <td>{{ $tempfile->title }}</td>
                                                        <td>{{ Str::limit($tempfile->author, 50, '...') }}</td>
                                                        <td>{{ $tempfile->adviser }}</td>
                                                        <td>{{ $tempfile->department }}</td>
                                                        <td>{{ Str::limit($tempfile->abstract, 150, '...') }}</td>
                                                        <td>{{ $tempfile->publication_date }}</td>
                                                        <td>{{ $tempfile->location }}</td>
                                                        <td>

                                                            <div class="btn-group text-sm-center" role="group"
                                                                aria-label="Basic mixed styles example">

                                                                <a href="{{ route('admin.temp.edit', ['tempfile' => $tempfile]) }}"
                                                                    class="btn btn-primary">Edit</a>

                                                                <button class="btn btn-outline-secondary dropdown-toggle"
                                                                    type="button" id="actionDropdown{{ $tempfile->id }}"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">

                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="actionDropdown{{ $tempfile->id }}">
                                                                    <li><a href="{{ route('admin.imrad.view.temp', ['tempfile' => $tempfile]) }}"
                                                                            class="dropdown-item">View</a>
                                                                    </li>

                                                                    {{-- <li>
                                                                        <form
                                                                            action="{{ route('admin.temp.delete', ['temp' => $tempfile]) }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="dropdown-item">Delete</button>
                                                                        </form>
                                                                    </li> --}}
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

            // Draft table functionality
            const dynamicAdviser_draftContainer = document.getElementById('dynamic_adviser_draft_container');
            const dynamicCategory_draftContainer = document.getElementById('dynamic_category_draft_container');
            const dynamicCourse_draftContainer = document.getElementById('dynamic_course_draft_container');
            const dynamicSDG_draftContainer = document.getElementById('dynamic_sdg_draft_container');
            const dynamicStart_draftContainer = document.getElementById('dynamic_start_draft_container');
            const dynamicEnd_draftContainer = document.getElementById('dynamic_end_draft_container');

            const dynamicFields_draftContainer = document.getElementById('dynamicFieldsContainer_draft');
            const applyButton_draft = document.getElementById('applyButton_draft');

            const seenValues_draft = new Set();

            function handleApply() {
                let isValid_draft = true;

                const startYear_draftField = document.querySelector('.dynamic_start_draft_select');
                const endYear_draftField = document.querySelector('.dynamic_end_draft_select');

                const startYear_draft = startYear_draftField ? startYear_draftField.value.trim() : '';
                const endYear_draft = endYear_draftField ? endYear_draftField.value.trim() : '';

                if (startYear_draft && endYear_draft && parseInt(startYear_draft) > parseInt(endYear_draft)) {
                    isValid_draft = false;
                    alert('Start Year should be less than or equal to End Year.');
                }

                if (!isValid_draft) return;

                const processDynamicFields = (selector_draft, label_draft) => {
                    const elements_draft = document.querySelectorAll(selector_draft);
                    elements_draft.forEach(select_draft => {
                        const value_draft = select_draft.value.trim();
                        if (value_draft && !seenValues_draft.has(value_draft)) {
                            seenValues_draft.add(value_draft);
                            const div_draft = createDynamicField(label_draft, value_draft);
                            const displayFields_draft = document.getElementById('displayFields_draft');
                            displayFields_draft.appendChild(div_draft);
                        }
                    });
                };

                processDynamicFields('.dynamic_adviser_draft_select', 'Adviser');
                processDynamicFields('.dynamic_category_draft_select', 'Category');
                processDynamicFields('.dynamic_course_draft_select', 'Department');
                processDynamicFields('.dynamic_sdg_draft_select', 'SDG');
                processDynamicFields('.dynamic_start_draft_select', 'Start Year');
                processDynamicFields('.dynamic_end_draft_select', 'End Year');
            }

            function createDynamicField(type, value) {
                const div_draft = document.createElement('div');
                div_draft.classList.add('dynamicField_draft');
                div_draft.innerHTML = `
                    <div class="input-group d-flex align-items-center me-2">
                    <span class="input-group-text_draft me-2">${type}</span>
                    <input type="text" value="${value}" readonly class="dynamicInput_draft form-control" name="${type.toLowerCase().replace(' ', '_')}[]">
                    <button type="button" class="deleteButton_draft btn btn-outline-secondary">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                    `;

                const hiddenInput_draft = document.createElement('input');
                hiddenInput_draft.type = 'hidden';
                hiddenInput_draft.name = type.toLowerCase().replace(' ', '_') + '[]';
                hiddenInput_draft.value = value;

                const displayFields_draft = document.getElementById('displayFields_draft');
                displayFields_draft.appendChild(hiddenInput_draft);

                div_draft.querySelector('.deleteButton_draft').addEventListener('click', () => {
                    seenValues_draft.delete(value);
                    div_draft.remove();
                    hiddenInput_draft.remove();
                    showFilterButton();
                });

                showFilterButton();

                return div_draft;
            }

            function showFilterButton() {
                const filterButton = document.getElementById('filterButton_draft');
                const displayFields = document.getElementById('displayFields_draft');

                if (displayFields.children.length > 0) {
                    filterButton.style.display = 'block';
                } else {
                    filterButton.style.display = 'none';
                }
            }

            document.getElementById('applyButton_draft').addEventListener('click', handleApply);

            // Select all checkbox
            const selectAllCheckbox = document.getElementById("select-all");
            const rowCheckboxes = document.querySelectorAll(".row-checkbox");
            const bulkActionButtons = document.getElementById("bulk-action-buttons");

            // Show/Hide bulk action buttons based on selected checkboxes
            const updateBulkActionButtons = () => {
                const anyChecked = Array.from(rowCheckboxes).some(checkbox => checkbox.checked);
                bulkActionButtons.style.display = anyChecked ? "block" : "none";
            };

            // Select/Deselect all checkboxes
            selectAllCheckbox.addEventListener("change", (e) => {
                rowCheckboxes.forEach(checkbox => checkbox.checked = e.target.checked);
                updateBulkActionButtons();
            });

            // Monitor individual row checkboxes
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateBulkActionButtons);
            });

            // Delete selected items
            document.getElementById("delete-selected").addEventListener("click", () => {
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
                        fetch('/admin/bulk-delete-draft', {
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
