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
