@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('header')
    @include('header')
@endsection

@section('nav')
    @include('nav')
@endsection

@section('content')
    <div class="profile-container">
        <div class="info-container item bg-white main-content">
            <div class="text-center">
                <span class="fw-bold fs-4 py-4 ">Personal Information</span>
            </div>
            <form method="POST" enctype="multipart/form-data" id="profileForm"
                action="
                    @if (Auth::guard('admin')->check()) {{ route('admin.update', ['user_code' => encrypt($user->user_code)]) }}
                    @else
                        {{ route('guest.account.update', ['user_code' => encrypt($user->user_code)]) }} @endif
                    ">
                @csrf

                @method('PUT')
                @if (session('success'))
                    <script>
                        Swal.fire({
                            title: 'Success!',
                            text: "{{ session('success') }}",
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                @if ($errors->any())
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                <div class="container mt-3">
                    <div class="row">
                        <!-- Profile Information Card on the Left Side -->
                        <div class="col-md-4 mb-3">
                            <div class="border p-4 rounded text-center">
                                <!-- Profile Image -->
                                <img src="{{ asset('assets/img/guest_profile/' . Auth::user()->profile) }}"
                                    alt="Profile Image" class="rounded-circle mb-3 mx-auto d-block" style="width: 150px;">

                                <!-- User Name -->
                                <h6 class="mb-1">{{ $user->name }}</h6> <!-- Dynamic Name -->

                                <!-- User Email -->
                                <p class="mb-2 text-muted">{{ $user->email }}</p> <!-- Dynamic Email -->

                            </div>
                        </div>

                        <!-- Form Fields in Two Columns on the Right Side -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <input id="user_code" type="hidden"
                                            class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                            value="{{ old('user_code', $user->user_code) }}" readonly>
                                        @error('user_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Name</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $user->email) }}" readonly>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label fw-bold">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                            name="gender" required>
                                            <option value="" disabled>Select Gender</option>
                                            <option value="male"
                                                {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other"
                                                {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="birthday" class="form-label fw-bold">Birthday</label>
                                        <input id="birthday" type="date"
                                            class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                            value="{{ old('birthday', $user->birthday) }}" onchange="calculateAge()">
                                        @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="age" class="form-label fw-bold">Age</label>
                                        <input id="age" type="number"
                                            class="form-control @error('age') is-invalid @enderror" name="age"
                                            value="{{ old('age', $user->age) }}" readonly>
                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="profile" class="form-label fw-bold">Profile Picture</label>
                                        <input id="profile" type="file"
                                            class="form-control @error('profile') is-invalid @enderror" name="profile">
                                        @error('profile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="col-md-12 update-btn ">
                                            <label for="profile" class="form-label fw-bold"></label>
                                            <button type="submit" class="w-100 update-button mt-2 btn border">
                                                {{ __('Update Profile') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
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
    </div>
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
