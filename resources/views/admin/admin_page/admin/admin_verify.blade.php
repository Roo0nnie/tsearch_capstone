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
    <div id="welcome">
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

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.verify.code') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('verification_code') is-invalid @enderror"
                                            id="verification_code" name="verification_code"
                                            value="{{ old('verification_code') }}" required autocomplete="verification_code"
                                            autofocus placeholder="Verification code">
                                        <label for="verification_code">{{ __('Enter verification code') }}</label>
                                        @error('verification_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="custom-button">
                                            {{ __('Verify Code') }}
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <a class="btn btn-link text-decoration-none"
                                            href="{{ route('admin.resend.verification.request') }}">
                                            {{ __('Resend Code') }}
                                        </a>
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
