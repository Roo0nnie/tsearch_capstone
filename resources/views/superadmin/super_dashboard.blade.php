@extends('layouts.super_admin')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
        </div>

        @include('superadmin.reports.user_files')

        @include('superadmin.reports.user_statistic')

        @include('superadmin.reports.report')

        @include('superadmin.reports.reports_linegraph')

    </div>
@endsection
