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
                        <h3 class="fw-bold mb-3">Report</h3>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <button type="button" class="btn btn-maroon me-2" data-bs-toggle="modal"
                            data-bs-target="#filter-database" data-button="published">
                            Filter Category
                        </button>

                        <form id="dynamicFieldsContainer_published" action="{{ route('report.generation.file.rating') }}"
                            method="GET" class="d-flex">
                            @csrf
                            <div id="displayFields" class="d-flex">

                            </div>
                            <button id="filterButton" type="submit" class="btn btn-primary mx-2"
                                style="display: none;">Apply</button>
                            <input type="hidden" name="filter_type" value="filter">
                        </form>
                    </div>

                    <div class="">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Download
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('download.pdf.file.rate') . '?' . http_build_query(['ids' => $imrads->pluck('id')->toArray()]) }}">PDF</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('download.excel.file.rate') . '?' . http_build_query(['ids' => $imrads->pluck('id')->toArray()]) }}">Excel</a>
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
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Published Files</h1>
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
                                                    <option value="">Select Status</option>
                                                    <option value="published">Published</option>
                                                    <option value="archive">Archive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Adviser Section -->
                                    <div id="dynamic_adviser_container">
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

                                    <div id="dynamic_rating_container">
                                        <div class="select-wrapper">
                                            <label for="rating_select">Rating</label>
                                            <div class="input-group">
                                                <select class="form-control dynamic_rating_select"
                                                    aria-label="Select Rating" name="rating[]">
                                                    <option value="">Select Rating</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
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

                {{-- Report File SDG --}}
                <div class="mt-3">
                    <div class="card table-responsive">
                        <div class="card-body">
                            <div class="container">
                                <div>
                                    <h3 class="fw-bold mb-3">File Downloads and Ratings</h3>
                                </div>
                                <div id="">
                                    <table id="report-file-download-rating"
                                        class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>Downloads</th>
                                                <th>Ratings</th>
                                                <th>Rated User</th>
                                                <th>Year</th>
                                                <th>Call#</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($imrads as $imrad)
                                                @php
                                                    $userCount = $imrad
                                                        ->ratings()
                                                        ->distinct('user_code')
                                                        ->count('user_code');
                                                @endphp
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $imrad->category }}</td>
                                                    <td>{{ $imrad->title }}</td>
                                                    <td>{{ $imrad->imradMetric->downloads }}</td>
                                                    <td>{{ $imrad->imradMetric->rates }}</td>
                                                    <td>{{ $userCount }}</td>
                                                    <td>{{ $imrad->publication_date }}</td>
                                                    <td>{{ $imrad->location }}</td>
                                                    <td>{{ $imrad->status }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.imrad.view', ['imrad' => $imrad]) }}"
                                                            class="btn btn-info btn-sm">View</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const dynamicCategoryContainer = document.getElementById('dynamic_category_container');
            const dynamicCourseContainer = document.getElementById('dynamic_course_container');
            const dynamicAdviserContainer = document.getElementById('dynamic_adviser_container');
            const dynamicRatingContainer = document.getElementById('dynamic_rating_container');
            const dynamicSDGContainer = document.getElementById('dynamic_sdg_container');
            const dynamicStartContainer = document.getElementById('dynamic_start_container');
            const dynamicEndContainer = document.getElementById('dynamic_end_container');
            const dynamicStatusContainer = document.getElementById('dynamic_status_container');

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

                processDynamicFields('.dynamic_category_select', 'Category');
                processDynamicFields('.dynamic_course_select', 'Department');
                processDynamicFields('.dynamic_rating_select', 'Rating');
                processDynamicFields('.dynamic_adviser_select', 'Adviser');
                processDynamicFields('.dynamic_sdg_select', 'SDG');
                processDynamicFields('.dynamic_start_select', 'Start_year');
                processDynamicFields('.dynamic_end_select', 'End_year');
                processDynamicFields('.dynamic_status_select', 'Status');
                processDynamicFields('.dynamic_start_create_select', 'Start_create');
                processDynamicFields('.dynamic_end_create_select', 'End_create');
            }

            function createDynamicField(type, value) {
                const div = document.createElement('div');
                div.classList.add('dynamicField');
                div.innerHTML = `
                <div class="input-group">
                    <span class="input-group-text">${type}</span>
                    <input type="text" value="${value}" readonly class="dynamicInput form-control" name="${type}[]">
                    <button type="button" class="deleteButton">
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
        });
    </script>

@endsection
