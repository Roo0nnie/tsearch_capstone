@extends('layouts.admin')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
        </div>

        @include('admin.admin_page.reports.reportsUsers_Files')

        @include('admin.admin_page.reports.report_user_statistics')

        @include('admin.admin_page.reports.reports')

        @include('admin.admin_page.reports.reports-sdg-linegraph')


    </div>
@endsection
