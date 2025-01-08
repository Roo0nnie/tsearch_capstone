@extends('layouts.app')

@section('header')
    @include('header')
@endsection

@section('nav')
    @include('nav')
@endsection

@section('content')
    @include('main_layouts.main', ['imrads' => $imrads])
@endsection

@section('footer')
    @include('footer')
@endsection

<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    })

    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('Screenshots are disabled.');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "F12") {
            e.preventDefault();
        }
        if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || (e.ctrlKey && e.key === 'U')) {
            e.preventDefault();
        }
    });
</script>
