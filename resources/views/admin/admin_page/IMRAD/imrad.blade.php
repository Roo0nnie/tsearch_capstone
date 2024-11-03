@extends('layouts.admin')


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
                    <h3 class="fw-bold mb-3">Thesis Files</h3>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="filter-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter-database"
                        data-button="published">
                        Filter Published Files
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#filter-database_1" data-button="archive">
                        Filter Archive Files
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#filter-database_2" data-button="draft">
                        Filter Draft Files
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Published Files</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.imrad') }}" method="GET">
                                    @csrf

                                    <div>
                                        <input type="hidden" name="filter_type" value="published">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Author -->
                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text" class="form-control" id="author" name="author"
                                                    placeholder="Enter author">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- Adviser -->
                                            <div class="mb-3">
                                                <label for="adviser" class="form-label">Adviser</label>
                                                <input type="text" class="form-control" id="adviser" name="adviser"
                                                    placeholder="Enter adviser">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Department -->
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <input type="text" class="form-control" id="department" name="department"
                                                    placeholder="Enter department">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Publication Date -->
                                            <div class="mb-3">
                                                <label for="publication_month" class="form-label">Publication
                                                    Month</label>
                                                <input type="text" class="form-control" id="publication_month"
                                                    name="publication_month" placeholder="Enter month: month">
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="publication_year" class="form-label">Publication Year</label>
                                                <input type="text" class="form-control" id="publication_year"
                                                    name="publication_year" placeholder="Enter year: MMMM">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Location -->
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Call #</label>
                                                <input type="text" class="form-control" id="location" name="location"
                                                    placeholder="Enter location">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- SDG -->
                                            <div class="mb-3">
                                                <label for="SDG" class="form-label">SDG</label>
                                                <input type="text" class="form-control" id="SDG" name="SDG"
                                                    placeholder="Enter SDG">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Filter IMRAD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database_1" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Archieve Files</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.imrad') }}" method="GET">
                                    @csrf

                                    <div>
                                        <input type="hidden" name="filter_type" value="archive">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Author -->
                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text" class="form-control" id="author" name="author"
                                                    placeholder="Enter author">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- Adviser -->
                                            <div class="mb-3">
                                                <label for="adviser" class="form-label">Adviser</label>
                                                <input type="text" class="form-control" id="adviser" name="adviser"
                                                    placeholder="Enter adviser">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Department -->
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <input type="text" class="form-control" id="department"
                                                    name="department" placeholder="Enter department">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Publication Date -->
                                            <div class="mb-3">
                                                <label for="publication_month" class="form-label">Publication
                                                    Month</label>
                                                <input type="text" class="form-control" id="publication_month"
                                                    name="publication_month" placeholder="Enter month: month">
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="publication_year" class="form-label">Publication Year</label>
                                                <input type="text" class="form-control" id="publication_year"
                                                    name="publication_year" placeholder="Enter year: MMMM">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Location -->
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Call #</label>
                                                <input type="text" class="form-control" id="location"
                                                    name="location" placeholder="Enter location">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- SDG -->
                                            <div class="mb-3">
                                                <label for="SDG" class="form-label">SDG</label>
                                                <input type="text" class="form-control" id="SDG" name="SDG"
                                                    placeholder="Enter SDG">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Filter IMRAD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="filter-database_2" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Draft Files</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.imrad') }}" method="GET">
                                    @csrf

                                    <div>
                                        <input type="hidden" name="filter_type" value="draft">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Author -->
                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text" class="form-control" id="author" name="author"
                                                    placeholder="Enter author">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- Adviser -->
                                            <div class="mb-3">
                                                <label for="adviser" class="form-label">Adviser</label>
                                                <input type="text" class="form-control" id="adviser" name="adviser"
                                                    placeholder="Enter adviser">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Department -->
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <input type="text" class="form-control" id="department"
                                                    name="department" placeholder="Enter department">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Publication Date -->
                                            <div class="mb-3">
                                                <label for="publication_month" class="form-label">Publication
                                                    Month</label>
                                                <input type="text" class="form-control" id="publication_month"
                                                    name="publication_month" placeholder="Enter month: month">
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="publication_year" class="form-label">Publication Year</label>
                                                <input type="text" class="form-control" id="publication_year"
                                                    name="publication_year" placeholder="Enter year: MMMM">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <!-- Location -->
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Call #</label>
                                                <input type="text" class="form-control" id="location"
                                                    name="location" placeholder="Enter location">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <!-- SDG -->
                                            <div class="mb-3">
                                                <label for="SDG" class="form-label">SDG</label>
                                                <input type="text" class="form-control" id="SDG" name="SDG"
                                                    placeholder="Enter SDG">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Filter IMRAD</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <form action="{{ route('admin.imrad.create') }}" method="POST" enctype="multipart/form-data"
                        class="d-flex w-100">
                        @csrf
                        <button type="button" class="btn btn-maroon"
                            onclick="document.getElementById('file-input').click();">
                            <span id="file-name">Choose File</span>
                        </button>
                        <input type="file" id="file-input" accept=".xlsx, .xls, .csv" name="file" required
                            style="display: none;" onchange="updateFileName()">
                        <button class="btn btn-maroon ms-2" type="submit">Add File</button>
                    </form>
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
                                    data-tab="published">Published Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="online-account-tab" data-bs-toggle="tab" href="#online-account"
                                    role="tab" aria-controls="online-account" aria-selected="false"
                                    data-tab="archive">Archive Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="offline-account-tab" data-bs-toggle="tab"
                                    href="#offline-account" role="tab" aria-controls="offline-account"
                                    aria-selected="false" data-tab="draft">Draft Files</a>
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
                                            <table id="file-datatables_1" class="display table table-striped table-hover">
                                                <thead>

                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Author</th>
                                                        <th scope="col">Adviser</th>
                                                        <th scope="col">Department</th>
                                                        <th scope="col">Abstract</th>
                                                        <th scope="col">Publisher</th>
                                                        <th scope="col">Publication Date</th>
                                                        <th scope="col">Keywords</th>
                                                        <th scope="col">Call #</th>
                                                        <th scope="col">SDG</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="imrad-table-body">
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($imrads as $imrad)
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $imrad->title }}</td>
                                                            <td>{{ $imrad->author }}</td>
                                                            <td>{{ $imrad->adviser }}</td>
                                                            <td>{{ $imrad->department }}</td>
                                                            <td>{{ $imrad->abstract }}</td>
                                                            <td>{{ $imrad->publisher }}</td>
                                                            <td>{{ $imrad->publication_date }}</td>
                                                            <td>{{ $imrad->keywords }}</td>
                                                            <td>{{ $imrad->location }}</td>
                                                            <td>{{ $imrad->SDG }}</td>
                                                            <td>

                                                                <div class="btn-group text-sm-center" role="group"
                                                                    aria-label="Basic mixed styles example">

                                                                    <a href="{{ route('admin.imrad.edit', ['imrad' => $imrad]) }}"
                                                                        class="btn-primary btn">Edit</a>

                                                                    <button
                                                                        class="btn btn-outline-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="actionDropdown{{ $imrad->id }}"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">

                                                                    </button>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="actionDropdown{{ $imrad->id }}">
                                                                        <li><a href="{{ route('admin.imrad.view', ['imrad' => $imrad]) }}"
                                                                                class="dropdown-item">View</a>
                                                                        </li>
                                                                        <li><a href="{{ route('admin.imrad.archive', ['imrad' => $imrad]) }}"
                                                                                class="dropdown-item">Archive</a>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.imrad.delete', ['imrad' => $imrad]) }}"
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
                                        <table id="file-datatables_2" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Author</th>
                                                    <th scope="col">Adviser</th>
                                                    <th scope="col">Department</th>
                                                    <th scope="col">Abstract</th>
                                                    <th scope="col">Publisher</th>
                                                    <th scope="col">Publication Date</th>
                                                    <th scope="col">Keywords</th>
                                                    <th scope="col">Call #</th>
                                                    <th scope="col">SDG</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="archive-table-body">
                                                @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($archives as $archive)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $archive->title }}</td>
                                                        <td>{{ $archive->author }}</td>
                                                        <td>{{ $archive->adviser }}</td>
                                                        <td>{{ $archive->department }}</td>
                                                        <td>{{ $archive->abstract }}</td>
                                                        <td>{{ $archive->publisher }}</td>
                                                        <td>{{ $archive->publication_date }}</td>
                                                        <td>{{ $archive->keywords }}</td>
                                                        <td>{{ $archive->location }}</td>
                                                        <td>{{ $archive->SDG }}</td>
                                                        <td>
                                                            <div class="btn-group text-sm-center" role="group"
                                                                aria-label="Basic mixed styles example">

                                                                <a href="{{ route('admin.archive.return', ['archive' => $archive]) }}"
                                                                    class="btn btn-primary">Published</a>

                                                                <button class="btn btn-outline-secondary dropdown-toggle"
                                                                    type="button" id="actionDropdown{{ $archive->id }}"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">

                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="actionDropdown{{ $archive->id }}">
                                                                    <li><a class="dropdown-item" {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                                            href="">View</a>
                                                                    </li>

                                                                    <li>
                                                                        <form
                                                                            action="{{ route('admin.archive.delete', ['archive' => $archive]) }}"
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

                            <!-- Invalid Users Tab -->
                            <div class="tab-pane fade" id="offline-account" role="tabpanel"
                                aria-labelledby="offline-account-tab">
                                <!-- Content for Invalid Users Tab -->
                                <div class="container">
                                    <div>
                                        <div id="imrad-table">
                                            <table id="file-datatables_3" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Author</th>
                                                        <th scope="col">Adviser</th>
                                                        <th scope="col">Department</th>
                                                        <th scope="col">Abstract</th>
                                                        <th scope="col">Publisher</th>
                                                        <th scope="col">Publication Date</th>
                                                        <th scope="col">Keywords</th>
                                                        <th scope="col">Call #</th>
                                                        <th scope="col">SDG</th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="temp-table-body">
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($tempfiles as $tempfile)
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $tempfile->title }}</td>
                                                            <td>{{ $tempfile->author }}</td>
                                                            <td>{{ $tempfile->adviser }}</td>
                                                            <td>{{ $tempfile->department }}</td>
                                                            <td>{{ $tempfile->abstract }}</td>
                                                            <td>{{ $tempfile->publisher }}</td>
                                                            <td>{{ $tempfile->publication_date }}</td>
                                                            <td>{{ $tempfile->keywords }}</td>
                                                            <td>{{ $tempfile->location }}</td>
                                                            <td>{{ $tempfile->SDG }}</td>
                                                            <td>

                                                                <div class="btn-group text-sm-center" role="group"
                                                                    aria-label="Basic mixed styles example">

                                                                    <a href="{{ route('admin.temp.edit', ['tempfile' => $tempfile]) }}"
                                                                        class="btn btn-primary">Edit</a>

                                                                    <button
                                                                        class="btn btn-outline-secondary dropdown-toggle"
                                                                        type="button"
                                                                        id="actionDropdown{{ $tempfile->id }}"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">

                                                                    </button>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="actionDropdown{{ $tempfile->id }}">
                                                                        <li><a class="dropdown-item" {{-- {{ route('admin.user.view', ['user' => $user]) }} --}}
                                                                                href="">View</a>
                                                                        </li>

                                                                        <li>
                                                                            <form
                                                                                action="{{ route('admin.temp.delete', ['temp' => $tempfile]) }}"
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for the active tab
            const urlParams = new URLSearchParams(window.location.search);
            let activeTabImrad = urlParams.get('tab');

            // If no tab in URL, check local storage
            if (!activeTabImrad) {
                activeTabImrad = localStorage.getItem('activeTabImrad') ||
                    'published'; // Default to 'published' if none
            }

            // Activate the tab and corresponding content
            let tabToActivate = document.querySelector(`a[data-tab="${activeTabImrad}"]`);
            if (tabToActivate) {
                var tab = new bootstrap.Tab(tabToActivate);
                tab.show();

                // Activate the corresponding content pane
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
                    localStorage.setItem('activeTabImrad', selectedTab);

                    // Show/Hide filter buttons based on the active tab
                    handleButtonVisibility(
                        selectedTab); // Show the appropriate filter button when the tab changes
                });
            });

            // Show/hide buttons based on active tab
            function handleButtonVisibility(tab) {
                // Hide all buttons initially
                document.querySelectorAll('.filter-buttons button').forEach(function(button) {
                    button.style.display = 'none';
                });

                // Show the button that matches the active tab
                let buttonToShow = document.querySelector('.filter-buttons button[data-button="' + tab + '"]');
                if (buttonToShow) {
                    buttonToShow.style.display = 'inline-block';
                }
            }

            // Set initial visibility of buttons based on the active tab
            handleButtonVisibility(activeTabImrad); // Show button on page load
        });

        $(document).ready(function() {
            // Optionally: Show the default button for the first tab when the page loads
            let initialTab = localStorage.getItem('activeTabImrad') || 'published';
            $('a[data-bs-toggle="tab"][data-tab="' + initialTab + '"]').trigger('shown.bs.tab');
        });
    </script>

@endsection
