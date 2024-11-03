{{-- @extends('layouts.app')

@section('side')
    <div class="wrapper" id="mainWrapper">
        <div class="nav">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="admin-nav-link " data-target="dashboard">Dashboard</a></li>
<li><a href="{{ route('admin.admin') }}" class="admin-nav-link" data-target="admin">Admin</a></li>
<li><a href="{{ route('admin.user') }}" class="admin-nav-link" data-target="user">User</a></li>
<li><a href="{{ route('admin.faculty') }}" class="admin-nav-link " data-target="faculty">Faculty</a></li>
<li><a href="{{ route('admin.guestAccount') }}" class="admin-nav-link active"
        data-target="guestaccount">Guest</a>
</li>
<li><a href="{{ route('admin.imrad') }}" class="admin-nav-link " data-target="thesis">Thesis</a></li>
<li><a href="{{ route('admin.dashboard') }}" class="admin-nav-link"
        data-target="ask-a-library">Ask-a-library</a></li>
<li><a href="{{ route('admin.announcement') }}" class="admin-nav-link "
        data-target="announcement">Announcement</a></li>
<li><a href="{{ route('admin.log') }}" class="admin-nav-link" data-target="log-history">Log
        History</a>
</li>

</ul>


</div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="">
        <div class="container">
            <div class="support-cat">
                <div class="container">
                    @if (session('success'))
                    <div class="alert alert-success alert-block" role="alert">

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
                    <div class="d-flex justify-content-between">

                        <div>
                            <a href="{{ route('admin.guestAccount.create') }}">
                                <button class="btn bg-primary">Add Guest</button>
                            </a>
                        </div>

                        <div>
                            <form action="{{ route('admin.faculty.import.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="" accept=".xlsx, .xls, .csv" name="file" required>
                                <button class="btn bg-primary" type="submit">Add Faculty</button>
                            </form>
                        </div>

                    </div>


                </div>
                <nav class="nav justify-content-center nav-bg">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#allguestaccount">All Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activeguest">Online Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#deactiveguest">Offline Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#invalid_faculty">Invalid Guest</a>
                    </li>
                </nav>

                <div class="tab-content">

                    <div id="allguestaccount" class="tab-pane fade show active">
                        <div class="container">
                            <div>
                                <div class="d-flex justify-content-between">

                                    <div class="input-group mb-3">
                                        <input type="text" name="query_guest" id="query_guest" class="form-control"
                                            placeholder="Search faculty...">
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="{{ route('guestAccount.view.pdf') }}"
                                                    target="_black">View as PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('guestAccount.download.pdf') }}"
                                                    target="_black">Download to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('guestAccount.export.excel') }}"
                                                    target="_black">Export to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                                <div id="faculty-table">
                                    <table class="table table-striped">
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
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $guestAccount->user_code }}</td>
                                                <td>{{ $guestAccount->name }}</td>
                                                <td>{{ $guestAccount->email }}</td>
                                                <td>{{ $guestAccount->phone }}</td>
                                                <td>{{ $guestAccount->birthday }}</td>
                                                <td>{{ $guestAccount->status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="activeguest" class="tab-pane fade">
                        <div class="container">
                            <div class="container">
                                <div>

                                    <div class="d-flex justify-content-between">

                                        <div class="input-group mb-3">
                                            <input type="text" name="query_guest_active" id="query_guest_active"
                                                class="form-control" placeholder="Search faculty...">
                                        </div>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="exportDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown1">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.view.pdf') }}"
                                                        target="_black">View as PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.download.pdf') }}"
                                                        target="_black">Download to
                                                        PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.export.excel') }}"
                                                        target="_black">Export to
                                                        Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div id="faculty_table">
                                        <table class="table table-striped">
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
                                                @if ($guestAccount->status === 'online')
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $guestAccount->user_code }}</td>
                                                    <td>{{ $guestAccount->name }}</td>
                                                    <td>{{ $guestAccount->email }}</td>
                                                    <td>{{ $guestAccount->phone }}</td>
                                                    <td>{{ $guestAccount->birthday }}</td>
                                                    <td>{{ $guestAccount->status }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                            class="btn btn-warning btn-sm">Edit</a>
                                                        <form
                                                            action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
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

                    <div id="deactiveguest" class="tab-pane fade">
                        <div class="container">
                            <div class="container">
                                <div class="container">
                                    <div>

                                        <div class="d-flex justify-content-between">

                                            <div class="input-group mb-3">
                                                <input type="text" name="query_guest_inactive"
                                                    id="query_guest_inactive" class="form-control"
                                                    placeholder="Search faculty...">
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="exportDropdown2" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="exportDropdown2">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('guestAccount.inactive.view.pdf') }}"
                                                            target="_black">View as PDF</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('guestAccount.inactive.download.pdf') }}"
                                                            target="_black">Download to
                                                            PDF</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('guestAccount.inactive.export.excel') }}"
                                                            target="_black">Export to
                                                            Excel</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                        <div id="">
                                            <table class="table table-striped">
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
                                                    @if ($guestAccount->status === 'offline')
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $guestAccount->user_code }}</td>
                                                        <td>{{ $guestAccount->name }}</td>
                                                        <td>{{ $guestAccount->email }}</td>
                                                        <td>{{ $guestAccount->phone }}</td>
                                                        <td>{{ $guestAccount->birthday }}</td>
                                                        <td>{{ $guestAccount->status }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form
                                                                action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
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

                    <div id="invalid_faculty" class="tab-pane fade">
                        <div class="container">
                            <div>
                                <div class="d-flex justify-content-between">

                                    <div class="input-group mb-3">
                                        <input type="text" name="query_faculty_invalid" id="query_faculty_invalid"
                                            class="form-control" placeholder="Search faculty...">
                                    </div>


                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="exportDropdown3" data-bs-toggle="dropdown" aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown3">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('faculty.invalid.view.pdf') }}"
                                                    target="_black">View as PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('faculty.invalid.download.pdf') }}"
                                                    target="_black">Download to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('faculty.invalid.export.excel') }}"
                                                    target="_black">Export to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                                <div id="faculty-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Birthday</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Error</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="faculty-invalid-table-body">
                                            @php
                                            $counter = 1;
                                            @endphp
                                            @foreach ($invalidfaculties as $invalidfaculty)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $invalidfaculty->user_code }}</td>
                                                <td>{{ $invalidfaculty->name }}</td>
                                                <td>{{ $invalidfaculty->email }}</td>
                                                <td>{{ $invalidfaculty->phone }}</td>
                                                <td>{{ $invalidfaculty->birthday }}</td>
                                                <td>{{ $invalidfaculty->status }}</td>
                                                <td>{{ $invalidfaculty->error_message }}</td>
                                                <td>
                                                    <a href="{{ route('admin.invalidfaculty.edit', ['invalidfaculty' => $invalidfaculty]) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('admin.invalidfaculty.delete', ['invalidfaculty' => $invalidfaculty->id]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
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
{{-- <script src="{{ asset('js/guest_search.js') }}"></script> --}}
{{-- @endsection --}}


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
                        <h3 class="fw-bold mb-3">Guest</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category ">Total Guests</p>
                                            <h4 class="card-title">
                                                {{ count($guestAccounts) }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Online Guests</p>
                                            <h4 class="card-title">
                                                {{ $guestAccounts->filter(fn($guestAccount) => $guestAccount->status === 'online')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-luggage-cart"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Offline Guests</p>
                                            <h4 class="card-title">
                                                {{ $guestAccounts->filter(fn($guestAccount) => $guestAccount->status === 'offline')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                            <i class="far fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Blocked Guests</p>
                                            <h4 class="card-title">
                                                {{ $guestAccounts->filter(fn($guestAccount) => $guestAccount->account_status === 'blocked')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center pt-2 pb-4 my-2">
                    <div class="ms-md-auto py-2 py-md-0 d-flex flex-column flex-sm-row align-items-center">
                        <div class="mb-2 mb-sm-0">
                            <!-- NILIPAT KO NALNG DITO YUNG EXPORT -->
                            {{-- <button class="btn btn-label-danger dropdown-toggle border border-danger" type="button"
                                id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="{{ route('guestAccount.view.pdf') }}"
                                        target="_black">View as PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('guestAccount.download.pdf') }}"
                                        target="_black">Download to
                                        PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('guestAccount.export.excel') }}"
                                        target="_black">Export to
                                        Excel</a>
                                </li>
                            </ul> --}}
                            {{-- <a href="{{ route('admin.guestAccount.create') }}" class="btn btn-maroon btn-round">Add
                                Guest</a> --}}
                        </div>

                        <!-- File upload form -->
                        <!-- WALA PANG ROUTE YUNG SA PAG IMPORT NG FILE PARA SA GUEST -->
                        {{-- <form action="{{ route('admin.faculty.import.store') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center px-2">
                        @csrf
                        <input type="file" id="file-input" accept=".xlsx, .xls, .csv" name="file" required style="display: none;" onchange="updateFileName()">
                        <button type="button" class="btn btn-maroon btn-round me-2" onclick="document.getElementById('file-input').click();">
                            <span id="file-name">Choose File</span>
                        </button>
                        <button class="btn btn-maroon btn-round" type="submit">Add Guests</button>
                    </form> --}}
                    </div>
                </div>

                <nav class="nav nav-tabs justify-content-center flex-wrap custom-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#allguestaccount">All Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activeguest">Online Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#deactiveguest">Offline Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#invalid_faculty">Blocked Guest</a>
                    </li>
                </nav>

                <div class="table-responsive mt-3">
                    <div class="tab-content">

                        <div id="allguestaccount" class="tab-pane fade show active">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <div class="dropdown">
                                            <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                                type="button" id="exportDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                                <li><a class="dropdown-item" href="{{ route('guestAccount.view.pdf') }}"
                                                        target="_black">View as PDF</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('guestAccount.download.pdf') }}"
                                                        target="_black">Download to
                                                        PDF</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('guestAccount.export.excel') }}"
                                                        target="_black">Export to
                                                        Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

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
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $guestAccount->user_code }}</td>
                                                        <td>{{ $guestAccount->name }}</td>
                                                        <td>{{ $guestAccount->email }}</td>
                                                        <td>{{ $guestAccount->phone }}</td>
                                                        <td>{{ $guestAccount->birthday }}</td>
                                                        <td>{{ $guestAccount->status }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form
                                                                action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="activeguest" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <div class="dropdown">
                                            <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                                type="button" id="exportDropdown1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown1">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.view.pdf') }}"
                                                        target="_black">View as PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.download.pdf') }}"
                                                        target="_black">Download to
                                                        PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.active.export.excel') }}"
                                                        target="_black">Export to
                                                        Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
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
                                                        @if ($guestAccount->status === 'online')
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td>{{ $guestAccount->user_code }}</td>
                                                                <td>{{ $guestAccount->name }}</td>
                                                                <td>{{ $guestAccount->email }}</td>
                                                                <td>{{ $guestAccount->phone }}</td>
                                                                <td>{{ $guestAccount->birthday }}</td>
                                                                <td>{{ $guestAccount->status }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                        class="btn btn-warning btn-sm">Edit</a>
                                                                    <form
                                                                        action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm">Delete</button>
                                                                    </form>
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

                        <div id="deactiveguest" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <div class="dropdown">
                                            <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                                type="button" id="exportDropdown2" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown2">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.inactive.view.pdf') }}"
                                                        target="_black">View as PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.inactive.download.pdf') }}"
                                                        target="_black">Download to
                                                        PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.inactive.export.excel') }}"
                                                        target="_black">Export to
                                                        Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

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
                                                            @if ($guestAccount->status === 'offline')
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>{{ $guestAccount->user_code }}</td>
                                                                    <td>{{ $guestAccount->name }}</td>
                                                                    <td>{{ $guestAccount->email }}</td>
                                                                    <td>{{ $guestAccount->phone }}</td>
                                                                    <td>{{ $guestAccount->birthday }}</td>
                                                                    <td>{{ $guestAccount->status }}</td>
                                                                    <td>
                                                                        <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                            class="btn btn-warning btn-sm">Edit</a>
                                                                        <form
                                                                            action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                            method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm">Delete</button>
                                                                        </form>
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

                        <div id="invalid_faculty" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <div class="dropdown">
                                            <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                                type="button" id="exportDropdown45" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown45">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.blocked.view.pdf') }}"
                                                        target="_black">View as PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.blocked.download.pdf') }}"
                                                        target="_black">Download to
                                                        PDF</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('guestAccount.blocked.export.excel') }}"
                                                        target="_black">Export to
                                                        Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="faculty_table">
                                        <table id="basic-datatables_4" class="display table table-striped table-hover">
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
                                                    @if ($guestAccount->account_status === 'blocked')
                                                        <tr>
                                                            <td>{{ $counter++ }}</td>
                                                            <td>{{ $guestAccount->user_code }}</td>
                                                            <td>{{ $guestAccount->name }}</td>
                                                            <td>{{ $guestAccount->email }}</td>
                                                            <td>{{ $guestAccount->phone }}</td>
                                                            <td>{{ $guestAccount->birthday }}</td>
                                                            <td>{{ $guestAccount->account_status }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.guestAccount.edit', ['guestAccount' => $guestAccount]) }}"
                                                                    class="btn btn-warning btn-sm">Edit</a>
                                                                <form
                                                                    action="{{ route('admin.guestAccount.delete', ['guestAccount' => $guestAccount]) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div id="faculty-table">
                                        <table id="basic-datatables_4" class="display table table-striped table-hover ">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">Birthday</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Error</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="faculty-invalid-table-body">
                                                @php
                                                    $counter = 1;
                                                @endphp
                                                @foreach ($invalidfaculties as $invalidfaculty)
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $invalidfaculty->user_code }}</td>
                                                        <td>{{ $invalidfaculty->name }}</td>
                                                        <td>{{ $invalidfaculty->email }}</td>
                                                        <td>{{ $invalidfaculty->phone }}</td>
                                                        <td>{{ $invalidfaculty->birthday }}</td>
                                                        <td>{{ $invalidfaculty->status }}</td>
                                                        <td>{{ $invalidfaculty->error_message }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.invalidfaculty.edit', ['invalidfaculty' => $invalidfaculty]) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form
                                                                action="{{ route('admin.invalidfaculty.delete', ['invalidfaculty' => $invalidfaculty->id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
