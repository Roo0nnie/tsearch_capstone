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
                        <h3 class="fw-bold mb-3">Log History</h3>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Download
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('download.pdf.logs.admin') . '?' . http_build_query(['ids' => $logs->pluck('id')->toArray()]) }}">PDF</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card table-responsive">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table id="logDeleted-datatables_sample" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Login</th>
                                        <th scope="col">Logout</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-table-body">
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $log->user_code }}</td>
                                            <td>{{ $log->name }}</td>
                                            <td>{{ $log->user_type }}</td>
                                            <td>{{ $log->login }}</td>
                                            <td>{{ $log->logout }}</td>
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
@endsection
