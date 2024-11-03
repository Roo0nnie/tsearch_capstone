@extends('layouts.admin')


@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3"> Add Student</h3>

            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.user.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="user_code"
                                    class="col-md-4 col-form-label text-md-end">{{ __('User ID') }}</label>

                                <div class="col-md-6">
                                    <input id="user_code" type="text"
                                        class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                        value="{{ old('user_code') }}" required autocomplete="user_code" autofocus>

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
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                        value="{{ old('email') }}" required autocomplete="email">

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
                                        value="{{ old('phone') }}" autocomplete="phone">

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
                                        value="{{ old('bday') }}" required autocomplete="bday">

                                    @error('bday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input id="type" type="hidden" class="form-control @error('type') is-invalid @enderror"
                                name="type" value="student" required autocomplete="type" autofocus>

                            {{-- <div class="row mb-3">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required autofocus>
                                        <option value="" disabled selected>Select Activation</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="row mb-3">
                                <input id="status" type="hidden"
                                    class="form-control @error('type') is-invalid @enderror" name="status" value="offline"
                                    required autocomplete="status" autofocus>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @extends('layouts.app')

@section('side')
    <div class="wrapper" id="mainWrapper">
        <div class="nav">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="admin-nav-link " data-target="dashboard">Dashboard</a></li>
                <li><a href="{{ route('admin.admin') }}" class="admin-nav-link " data-target="admin">Admin</a></li>
                <li><a href="{{ route('admin.user') }}" class="admin-nav-link active" data-target="user">User</a></li>
                <li><a href="{{ route('admin.faculty') }}" class="admin-nav-link " data-target="faculty">Faculty</a></li>
                <li><a href="{{ route('admin.guestAccount') }}" class="admin-nav-link " data-target="guestaccount">Guest</a>
                </li>
                <li><a href="{{ route('admin.imrad') }}" class="admin-nav-link " data-target="thesis">Thesis</a></li>
                <li><a href="{{ route('admin.dashboard') }}" class="admin-nav-link"
                        data-target="ask-a-library">Ask-a-library</a></li>
                <li><a href="{{ route('admin.announcement') }}" class="admin-nav-link "
                        data-target="announcement">Announcement</a></li>
                <li><a href="{{ route('admin.log') }}" class="admin-nav-link " data-target="log-history">Log
                        History</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.user.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="user_code"
                                    class="col-md-4 col-form-label text-md-end">{{ __('User ID') }}</label>

                                <div class="col-md-6">
                                    <input id="user_code" type="text"
                                        class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                        value="{{ old('user_code') }}" required autocomplete="user_code" autofocus>

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
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                        value="{{ old('email') }}" required autocomplete="email">

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
                                        value="{{ old('phone') }}" autocomplete="phone">

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
                                        value="{{ old('bday') }}" required autocomplete="bday">

                                    @error('bday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input id="type" type="hidden" class="form-control @error('type') is-invalid @enderror"
                                name="type" value="student" required autocomplete="type" autofocus> --}}

{{-- <div class="row mb-3">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required autofocus>
                                        <option value="" disabled selected>Select Activation</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
{{--
                            <div class="row mb-3">
                                <input id="status" type="hidden"
                                    class="form-control @error('type') is-invalid @enderror" name="status"
                                    value="offline" required autocomplete="status" autofocus>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
