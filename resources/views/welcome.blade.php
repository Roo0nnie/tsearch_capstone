@extends('layouts.app')

@section('nav')
    @include('nav')
@endsection

@section('content')
    <div id="welcome">
        <div class="login-container d-flex justify-content-center align-items-center">
            <div class="row justify-content-center">
                <div class="welcome-box col-12 col-md-6 mt-3 col-sm-12 mt-5">
                    <div class=" row justify-content-center align-items-center">
                        <div class=" col-12x text-center">

                            <div class="circle mb-4">
                                <img src="/resources/image/logo.png" class="img-fluid" alt="logo">
                            </div>
                            <h3>Thesis Management System</h3>
                            <p>Sorsogon State University</p>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('authenticate'))
                                <div id="success-alert" class="alert alert-success mt-2" role="alert">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p style="font-size: 14px">{{ session('authenticate') }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="button-group">
                                <a href="{{ route('guest.auth.google') }}" class="custom-button">
                                    {{ __('SSU Login') }}
                                </a>
                                <a href="{{ route('guest.page') }}" class="custom-button">Guest</a>
                                <a href="{{ route('login', ['userType' => 'admin']) }}"
                                    class="custom-button">Administrator</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
