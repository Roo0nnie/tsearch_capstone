@extends('layouts.app')

@section('message')
    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
@endsection

@section('nav')
    @include('nav') <!-- Make sure this includes your navigation bar -->
@endsection

@section('content')
    <div class="login-container d-flex justify-content-center align-items-center">
        <div class="row justify-content-center">
            <div class="welcome-box col-12 col-md-6 mt-3 col-sm-12 mt-5">
                <div class=" row justify-content-center align-items-center">
                    <div class=" col-12x text-center">

                        <div class="circle mb-4">
                            <img src="/resources/image/logo.png" class="img-fluid" alt="">
                        </div>
                        <h1>Thesis Management System</h1>
                        <p>Sorsogon State University</p>
                        <div class="button-group mt-3">

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="">
                                        <div class="form-floating">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}" required
                                                autocomplete="email" autofocus placeholder="Email">
                                            <label for="email">{{ __('Email') }}</label>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="custom-button">{{ __('Send Password Reset Link') }}</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
