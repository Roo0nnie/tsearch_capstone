@extends('layouts.app')

@section('header')
    @include('header')
@endsection

@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="main-container item bg-white main-content">
        <div class="text-center">
            <span>General Information</span>
        </div>
        <form method="POST" enctype="multipart/form-data" id="profileForm"
            action="
                    @if (Auth::guard('user')->check()) {{ route('home.update', ['user_code' => encrypt($user->user_code)]) }}
                                @elseif (Auth::guard('faculty')->check())
                                    {{ route('faculty.update', ['user_code' => encrypt($user->user_code)]) }}
                                @elseif (Auth::guard('admin')->check())
                                    {{ route('admin.update', ['user_code' => encrypt($user->user_code)]) }}
                                @else
                                {{ route('guest.account.update', ['user_code' => encrypt($user->user_code)]) }} @endif
                    ">
            @csrf

            @method('PUT')
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div id="user_code1">
                <div class="row mb-3">
                    <label for="user_code" class="col-md-4 col-form-label text-md-end">{{ __('User Code') }}</label>

                    <div class="col-md-6">
                        <input id="user_code" type="text" class="form-control @error('user_code') is-invalid @enderror"
                            name="user_code" value="{{ old('user_code', $user->user_code) }}" required
                            autocomplete="user_code" readonly autofocus>

                        @error('user_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email', $user->email) }}" required readonly autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                        name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="phone">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                <div class="col-md-6">
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                        required>
                        <option value="" disabled>Select Gender</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                            Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                            Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                            Other</option>
                    </select>
                    @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3" id="bday">
                <label for="birthday" class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                <div class="col-md-6">
                    <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror"
                        name="birthday" value="{{ old('birthday', $user->birthday) }}" autocomplete="birthday"
                        onchange="calculateAge()">

                    @error('birthday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3" id="age-section">
                <label for="age" class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                <div class="col-md-6">
                    <input id="age" type="number" class="form-control @error('age') is-invalid @enderror"
                        name="age" value="{{ old('age', $user->age) }}" autocomplete="age" readonly>

                    @error('age')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="profile" class="col-md-4 col-form-label text-md-end">{{ __('Profile') }}</label>

                <div class="col-md-6">
                    <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror"
                        name="profile">

                    @error('profile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="custom-button">
                        {{ __('Update Profile') }}
                    </button>
                </div>
            </div>
        </form>

        {{-- set password --}}
        {{-- <div id="user_code12" style="{{ $hiddenCode ? 'display: block;' : 'display: none;' }}">
            <form method="POST"
                action="
            @if (Auth::guard('faculty')->check()) {{ route('faculty.password.update', ['user_code' => encrypt($user->user_code)]) }}
            @elseif (Auth::guard('user')->check())
                {{ route('home.password.update', ['user_code' => encrypt($user->user_code)]) }}
            @elseif (Auth::guard('admin')->check())
                {{ route('admin.password.update', ['user_code' => encrypt($user->user_code)]) }}
            @elseif(Auth::guard('guest_account')->check())
                {{ route('guest.account.password.update', ['user_code' => encrypt($user->user_code)]) }} @endif">

                @csrf

                @if (session('successpass'))
                    <div class="alert alert-success" role="alert">
                        {{ session('successpass') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @method('PUT')

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm"
                        class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="custom-button">
                            {{ __('Set Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div> --}}


        <script>
            function calculateAge() {
                const birthdayInput = document.getElementById('birthday');
                const ageInput = document.getElementById('age');

                if (birthdayInput.value) {
                    const birthDate = new Date(birthdayInput.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDifference = today.getMonth() - birthDate.getMonth();

                    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageInput.value = age;
                } else {
                    ageInput.value = '';
                }
            }
        </script>
    </div>


@endsection

@section('footer')
    @include('footer')
@endsection
