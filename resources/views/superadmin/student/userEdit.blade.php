@extends('layouts.admin')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3"> Edit Student Details</h3>

            </div>

        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Edit User') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.user.update', ['user' => $user]) }}">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
                                <input id="type" type="hidden"
                                    class="form-control @error('type') is-invalid @enderror" name="type"
                                    value="{{ $user->type }}" required autofocus>

                                <div class="row mb-3">
                                    <label for="user_code"
                                        class="col-md-4 col-form-label text-md-end">{{ __('User Code') }}</label>

                                    <div class="col-md-6">
                                        <input id="user_code" type="text"
                                            class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                            value="{{ old('user_code', $user->user_code) }}" required
                                            autocomplete="user_code" autofocus>

                                        @error('user_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $user->email) }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone', $user->phone) }}" autocomplete="phone">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="bday"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Birthday') }}</label>

                                    <div class="col-md-6">
                                        <input id="bday" type="date"
                                            class="form-control @error('bday') is-invalid @enderror" name="bday"
                                            value="{{ old('bday', $user->birthday) }}" required autocomplete="bday">

                                        @error('bday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="row mb-3">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('type') is-invalid @enderror" id="type"
                                        name="type" required>
                                        <option value="" disabled>Select Activation</option>
                                        <option value="admin"
                                            {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="student"
                                            {{ old('type', $user->type) == 'student' ? 'selected' : '' }}>
                                            Student</option>
                                        <option value="faculty"
                                            {{ old('type', $user->type) == 'faculty' ? 'selected' : '' }}>
                                            Faculty</option>
                                        <option value="guest"
                                            {{ old('type', $user->type) == 'guest' ? 'selected' : '' }}>
                                            Guest</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}


                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
