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
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login', ['userType' => $userType]) }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus placeholder="Enter email">
                                        <label for="email">{{ __('Enter email') }}</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        @if (session('secondsRemaining'))
                                            <span id="lockout-message" class="logged_attempts">
                                                Too many login attempts. Please try again in <span
                                                    id="countdown">{{ session('secondsRemaining') }}</span> seconds.
                                            </span>
                                            <script>
                                                var remainingTime = {{ session('secondsRemaining') }};

                                                function startCountdown(timeLeft) {
                                                    var countdownElement = document.getElementById('countdown');
                                                    var interval = setInterval(function() {

                                                        timeLeft--;

                                                        countdownElement.textContent = timeLeft;

                                                        if (timeLeft <= 0) {
                                                            clearInterval(interval);
                                                            document.getElementById('lockout-message').style.color = "green";
                                                            document.getElementById('lockout-message').textContent = 'You can now try logging in again.';
                                                        }
                                                    }, 1000);
                                                }

                                                startCountdown(remainingTime);
                                            </script>
                                        @endif
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" placeholder="Password" name="password" required
                                            autocomplete="current-password">
                                        <label for="password">{{ __('Password') }}</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{--
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div> --}}

                                    <div class="form-group">
                                        <button type="submit" class="custom-button">
                                            {{ __('Login') }}
                                        </button>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
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
