@extends('layouts.app')

@section('header')
    @include('header')
@endsection

@section('nav')
    @include('nav')
@endsection

@section('content')
    @if (session('success'))
        <div id="success-alert" class="alert alert-success mt-2" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <p>{{ session('success') }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-2" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @include('main_layouts.main', ['imrads' => $imrads])
@endsection

@section('footer')
    @include('footer')
@endsection

<script>
    function closeAlert() {
        var alert = document.getElementById('success-alert');
        alert.style.display = 'none';
    }
</script>
