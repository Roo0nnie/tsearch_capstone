@extends('layouts.admin')

@section('content')
    <div class="page-inner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Edit Invalid Faculty') }}</div>

                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('admin.invalidfaculty.update', ['invalidfaculty' => $invalidfaculty]) }}">
                                @csrf
                                @method('PUT')
                                <input id="type" type="hidden" class="form-control @error('type') is-invalid @enderror"
                                    name="type" value="{{ $invalidfaculty->type }}" required autofocus>
                                {{-- @if ($errors->any())
                                    <div class="alert alert-danger">

                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif --}}

                                @if (!empty($invalidfaculty->error_message))
                                    <div class="alert alert-danger" role="alert">
                                        {{ $invalidfaculty->error_message }}
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <label for="user_code"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Faculty Code') }}</label>

                                    <div class="col-md-6">
                                        <input id="user_code" type="text"
                                            class="form-control @error('user_code') is-invalid @enderror" name="user_code"
                                            value="{{ old('user_code', $invalidfaculty->user_code) }}" required
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
                                            value="{{ old('name', $invalidfaculty->name) }}" required autocomplete="name"
                                            autofocus>

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
                                            value="{{ old('email', $invalidfaculty->email) }}" required
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
                                            value="{{ old('phone', $invalidfaculty->phone) }}" autocomplete="phone">

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
                                            value="{{ old('bday', $invalidfaculty->birthday) }}" required
                                            autocomplete="bday">

                                        @error('bday')
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
