@extends('layouts.super_admin')


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
                        <h3 class="fw-bold mb-3">Student</h3>
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
                                            <p class="card-category ">Total Users</p>
                                            <h4 class="card-title">
                                                {{ count($users) }}
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
                                            <p class="card-category">Invalid Users</p>
                                            <h4 class="card-title">
                                                {{ count($invalidusers) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
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
                                            <p class="card-category">Recently Added Users</p>
                                            <h4 class="card-title">
                                                <h4 class="card-title">
                                                    {{ $users->filter(fn($user) => $user->created_at >= now()->subDay())->count() }}
                                                </h4>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
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
                                            <p class="card-category">Online Users</p>
                                            <h4 class="card-title">
                                                {{ $users->filter(fn($user) => $user->status === 'online')->count() }}
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
                                            <p class="card-category">Offline Users</p>
                                            <h4 class="card-title">
                                                {{ $users->filter(fn($user) => $user->status === 'offline')->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
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
                                            <p class="card-category">Recently Modified Users</p>
                                            <h4 class="card-title">
                                                <h4 class="card-title">
                                                    {{ $users->filter(fn($user) => $user->updated_at >= now()->subDay())->count() }}
                                                </h4>
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

                            <a href="{{ route('super_admin.user.create') }}" class="btn btn-maroon btn-round">Add
                                Student</a>
                        </div>

                        <form action="{{ route('super_admin.user.import.store') }}" method="POST"
                            enctype="multipart/form-data" class="d-flex align-items-center px-2">
                            @csrf
                            <input type="file" id="file-input" accept=".xlsx, .xls, .csv" name="file" required
                                style="display: none;" onchange="updateFileName()">
                            <button type="button" class="btn btn-maroon btn-round me-2"
                                onclick="document.getElementById('file-input').click();">
                                <span id="file-name">Choose File</span>
                            </button>
                            <button class="btn btn-maroon btn-round" type="submit">Add Users</button>
                        </form>

                    </div>
                </div>


                <nav class="nav nav-tabs justify-content-center flex-wrap custom-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#alluser">All User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#activeUser">Online User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#deactiveUser">Offline User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#invalid_user">Invalid User</a>
                    </li>
                </nav>



                <div class="table-responsive mt-3">
                    <div class="tab-content">
                        <div id="alluser" class="tab-pane fade show active">
                            <div class="container">
                                <div>
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                            type="button" id="exportDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="{{ route('super_admin.view.pdf') }}"
                                                    target="_black">View as
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('super_admin.download.pdf') }}"
                                                    target="_black">Download
                                                    to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('super_admin.export.excel') }}"
                                                    target="_black">Export
                                                    to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="user-table">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
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
                                            <tbody id="user-table-body">
                                                @php $count = 1; @endphp
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $user->user_code }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ $user->birthday }}</td>
                                                        <td>{{ $user->status }}</td>
                                                        <td>
                                                            <a href="{{ route('super_admin.user.edit', ['user' => $user]) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form
                                                                action="{{ route('super_admin.user.delete', ['user' => $user]) }}"
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

                        <div id="activeUser" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                            type="button" id="exportDropdown1" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown1">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.active.view.pdf') }}"
                                                    target="_black">View as PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.active.download.pdf') }}"
                                                    target="_black">Download to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.active.export.excel') }}"
                                                    target="_black">Export to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div id="user_table">
                                            <table id="basic-datatables_2"
                                                class="display table table-striped table-hover">
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
                                                <tbody id="userActive-table-body">
                                                    @foreach ($users as $user)
                                                        @php $count = 1; @endphp
                                                        @if ($user->status === 'online')
                                                            <tr>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $user->user_code }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->phone }}</td>
                                                                <td>{{ $user->birthday }}</td>
                                                                <td>{{ $user->status }}</td>
                                                                <td>
                                                                    <a href="{{ route('super_admin.user.edit', ['user' => $user]) }}"
                                                                        class="btn btn-warning btn-sm">Edit</a>
                                                                    <form
                                                                        action="{{ route('super_admin.user.delete', ['user' => $user]) }}"
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

                        <div id="deactiveUser" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                            type="button" id="exportDropdown2" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown2">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.inactive.view.pdf') }}"
                                                    target="_black">View as PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.inactive.download.pdf') }}"
                                                    target="_black">Download to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.inactive.export.excel') }}"
                                                    target="_black">Export to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div id="">
                                            <table id="basic-datatables_3"
                                                class="display table table-striped table-hover">
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
                                                <tbody id="userDeactive-table-body">
                                                    @php $count = 1; @endphp
                                                    @foreach ($users as $user)
                                                        @if ($user->status === 'offline')
                                                            <tr>
                                                                <td>{{ $count++ }}</td>
                                                                <td>{{ $user->user_code }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->phone }}</td>
                                                                <td>{{ $user->birthday }}</td>
                                                                <td>{{ $user->status }}</td>
                                                                <td>
                                                                    <a href="{{ route('super_admin.user.edit', ['user' => $user]) }}"
                                                                        class="btn btn-warning btn-sm">Edit</a>
                                                                    <form
                                                                        action="{{ route('super_admin.user.delete', ['user' => $user]) }}"
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

                        <div id="invalid_user" class="tab-pane fade">
                            <div class="container">
                                <div class="container">
                                    <div class="container mb-2 justify-content-end d-flex">
                                        <button class="btn btn-label-danger dropdown-toggle border border-danger"
                                            type="button" id="exportDropdown3" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown3">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.invalid.view.pdf') }}"
                                                    target="_black">View as PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.invalid.download.pdf') }}"
                                                    target="_black">Download to
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('super_admin.invalid.export.excel') }}"
                                                    target="_black">Export to
                                                    Excel</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="user-table">
                                        <table id="basic-datatables_4" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">Birthday</th>
                                                    <th scope="col">Error</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="user-invalid-table-body">
                                                @php $count = 1; @endphp
                                                @foreach ($invalidusers as $invaliduser)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $invaliduser->user_code }}</td>
                                                        <td>{{ $invaliduser->name }}</td>
                                                        <td>{{ $invaliduser->email }}</td>
                                                        <td>{{ $invaliduser->phone }}</td>
                                                        <td>{{ $invaliduser->birthday }}</td>
                                                        <td>{{ $invaliduser->error_message }}</td>
                                                        <td>
                                                            <a href="{{ route('super_admin.invaliduser.edit', ['invaliduser' => $invaliduser]) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form
                                                                action="{{ route('super_admin.invaliduser.delete', ['invaliduser' => $invaliduser]) }}"
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
@endsection
