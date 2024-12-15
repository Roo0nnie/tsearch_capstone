@extends('layouts.admin')


@section('content')
    <div class="page-inner">
        <div class="container">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Edit Guest Details</h3>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Edit Guest') }}</div>

                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('admin.guestAccount.update', ['guestAccount' => $guestAccount]) }}">
                                @csrf
                                @method('PUT')
                                <input id="type" type="hidden"
                                    class="form-control @error('type') is-invalid @enderror" name="type"
                                    value="{{ $guestAccount->type }}" required autofocus>
                                <input id="status" type="hidden"
                                    class="form-control @error('status') is-invalid @enderror" name="status"
                                    value="{{ $guestAccount->status }}" required autofocus>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="user_code" type="hidden"
                                            class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                            value="{{ old('user_code', $guestAccount->user_code) }}" required
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
                                            value="{{ old('name', $guestAccount->name) }}" required readonly
                                            autocomplete="name" autofocus>

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
                                            value="{{ old('email', $guestAccount->email) }}" required readonly
                                            autocomplete="email">

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
                                            value="{{ old('phone', $guestAccount->phone) }}" readonly autocomplete="phone">

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="gender"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                            name="gender_display" disabled>
                                            <option value="" disabled>Select Gender</option>
                                            <option value="male" {{ $guestAccount->gender == 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ $guestAccount->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other"
                                                {{ $guestAccount->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>

                                        <!-- Hidden input to submit gender value -->
                                        <input type="hidden" name="gender" value="{{ $guestAccount->gender }}">

                                        @error('gender')
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
                                            value="{{ old('bday', $guestAccount->birthday) }}" readonly
                                            autocomplete="bday">

                                        @error('bday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3" id="age-section">
                                    <label for="age"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                                    <div class="col-md-6">
                                        <input id="age" type="number"
                                            class="form-control @error('age') is-invalid @enderror" name="age"
                                            value="{{ old('age', $guestAccount->age) }}" autocomplete="age" readonly>

                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="status"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="" disabled>Account Status</option>
                                            <option value="active"
                                                {{ old('status', $guestAccount->account_status) == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="blocked"
                                                {{ old('status', $guestAccount->account_status) == 'blocked' ? 'selected' : '' }}>
                                                Blocked</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


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
