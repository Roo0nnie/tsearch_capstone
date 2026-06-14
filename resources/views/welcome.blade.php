@extends('layouts.app')

@section('nav')
    @include('nav')
@endsection

@section('content')
    <div id="welcome">
        <div class="login-container">
            <div class="welcome-box">
                <div class="circle">
                    <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" class="img-fluid" alt="T-SEARCH logo">
                </div>

                <h3>Thesis Management System</h3>
                <p>Sorsogon State University</p>

                @if (session('error'))
                    <div class="alert alert-danger mb-3" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('authenticate'))
                    <div id="success-alert" class="alert alert-success mb-3" role="alert">
                        <p class="mb-0 text-sm">{{ session('authenticate') }}</p>
                    </div>
                @endif

                <div class="button-group">
                    @if (app()->environment('local'))
                        <a href="{{ route('dev.login', 'student') }}" class="custom-button btn-primary-custom">
                            {{ __('SSU Login') }}
                        </a>
                        <a href="{{ route('dev.login', 'guest') }}" class="custom-button btn-secondary-custom">Guest</a>
                        <a href="{{ route('dev.login', 'admin') }}" class="custom-button btn-secondary-custom">Administrator</a>
                        <a href="{{ route('dev.login', 'faculty') }}" class="custom-button btn-secondary-custom">Faculty</a>
                        <a href="{{ route('dev.login', 'superadmin') }}" class="custom-button btn-secondary-custom">Super Admin</a>
                        <p class="mt-4 text-xs text-slate-500">
                            Dev mode: one-click login as seed users (password: password)
                        </p>
                    @else
                        <a href="{{ route('guest.auth.google') }}" class="custom-button btn-primary-custom">
                            {{ __('SSU Login') }}
                        </a>
                        <a href="{{ route('guest.page') }}" class="custom-button btn-secondary-custom">Guest</a>
                        <a href="{{ route('login', ['userType' => 'admin']) }}"
                            class="custom-button btn-secondary-custom">Administrator</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
