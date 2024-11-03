@extends('layouts.app')

@section('content')
    <div class="container text-center"
        style="background-color: white; height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="alert alert-warning">
            <h2>Confirm</h2>
            @auth('user')
                <!-- Ensure the user is authenticated with the 'user' guard -->
                <p>You are already logged in as <strong></strong>. You need to log out before
                    logging in as a different user.</p>

                <div class="button-group">
                    <a href="{{ route('logout') }}" class="btn btn-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <p>You are not logged in.</p>
            @endauth
        </div>
    </div>
@endsection
