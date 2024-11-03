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
            <span>User Preference</span>
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
        </div>

        <h3>Authors</h3>
        <form method="POST"
            action="
        @if (Auth::guard('user')->check()) {{ route('user.save.preferences') }}">
        @elseif (Auth::guard('faculty')->check())
            {{ route('faculty.save.preferences') }}">
        @elseif (Auth::guard('guest_account')->check())
            {{ route('guest.account.save.preferences') }}"> @endif

            @csrf
            <ul>
                @forelse ($authorList as $author)
<li>
                        <input type="checkbox"
            name="authors[]" value="{{ $author }}" @if (in_array($author, $selectedAuthors)) checked @endif>
            {{ $author }}
            </li>
            @empty
                <p>No Authors Available</p>
                @endforelse
                </ul>

                <h3>Advisers</h3>
                <ul>
                    @forelse ($adviserList as $adviser)
                        <li>
                            <input type="checkbox" name="advisers[]" value="{{ $adviser }}"
                                @if (in_array($adviser, $selectedAdvisers)) checked @endif>
                            {{ $adviser }}
                        </li>
                    @empty
                        <p>No Advisers Available</p>
                    @endforelse
                </ul>

                <h3>Departments</h3>
                <ul>
                    @forelse ($departmentList as $department)
                        <li>
                            <input type="checkbox" name="departments[]" value="{{ $department }}"
                                @if (in_array($department, $selectedDepartments)) checked @endif>
                            {{ $department }}
                        </li>
                    @empty
                        <p>No Departments Available</p>
                    @endforelse
                </ul>

                <button type="submit" class="custom-button">Save Preferences</button>
            </form>

        </div>

        <script src="{{ asset('js/user_preference.js') }}"></script>
    @endsection

    @section('footer')
        @include('footer')
    @endsection
