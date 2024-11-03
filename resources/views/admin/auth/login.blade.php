@extends('layouts.app')

@section('message')
    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
@endsection
@section('nav')
    @include('nav')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 col-sm-12">
                <div class="welcomeRightSide"></div>
            </div>
            <div class="col-12 col-md-6 mt-3 col-sm-12">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 text-center">
                        <div class="welcome-box">
                            <div class="circle mb-4">
                                <img src="/resources/image/logo.png" class="img-fluid" alt="">
                            </div>
                            <h1>Thesis Management System</h1>
                            <p>Sorsogon State University</p>
                            <div class="button-group mt-3">
                                <form method="POST" action="{{ route('admin.login.submit', ['userType' => $userType]) }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="admin_id"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Admin ID') }}</label>

                                        <div class="col-md-6">
                                            <input id="admin_id" type="text"
                                                class="form-control @error('admin_id') is-invalid @enderror" name="admin_id"
                                                value="{{ old('admin_id') }}" required autocomplete="admin_id" autofocus>

                                            @error('admin_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus placeholder="Email Address">
                                        <label for="email">{{ __('Email Address') }}</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating">
                                        <input type="password"
                                            class="form-control form-control-sm @error('password') is-invalid @enderror"
                                            id="password" placeholder="Password" name="password" required
                                            autocomplete="current-password">
                                        <label for="password">{{ __('Password') }}</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-check text-start mt-1">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="custom-button">
                                            {{ __('Login') }}
                                        </button>
                                        @if (Route::has('admin.password.request'))
                                            <a class="text-primary" href="{{ route('admin.password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
