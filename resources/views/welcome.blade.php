@extends('layouts.app')

@section('nav')
    @include('nav')
@endsection

@section('content')
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
                        <div class="button-group">
                            <a href="{{ route('login', ['userType' => 'admin']) }}" class="custom-button">Administrator</a>
                            <a href="{{ route('guest.auth.google') }}" class="custom-button">
                                {{ __('University Login') }}
                            </a>
                            <a href="{{ route('guest.page') }}" class="custom-button">Guest</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
