<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- logo --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/kaiadmin/ssu_logo.png') }}" type="image/png">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS styling -->
    @vite(['resources/sass/app.scss', 'resources/css/welcome.css', 'resources/css/welcome_manual.css', 'resources/js/app.js', 'resources/js/nav.js', 'resources/js/announcement.js', 'resources/js/profile.js', 'resources/js/user_search.js', 'resources/js/faculty_search.js', 'resources/js/guest_search.js', 'resources/js/imrad_search.js', 'resources/js/rating.js'])
    {{-- Sweet Alert CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Sweet Alert JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
</head>

<body data-route="{{ Route::currentRouteName() }}">
    <div id="app">
        @if (!Str::contains(Route::currentRouteName(), 'admin') || Str::contains(Route::currentRouteName(), 'admin.login'))
            @yield('message')
            @yield('header')
            @yield('nav')
            <main class="">
                @yield('content')
            </main>
            @yield('footer')
        @else
            <div class="">
                <div class="grid-nav grid-item">@include('nav')</div>
                @yield('side')
                @yield('content')
            </div>
            @yield('footer')
    </div>
    @endif
    <button class="fixed-button "><a
            href="https://docs.google.com/forms/d/e/1FAIpQLScZ14WhnFoac_G0nytradkuUXi-pH_WmACQwvkgk-MCsNYb5Q/viewform?usp=pp_url"
            target="_blank">IT
            Expert Survey</a></button>
    </div>
</body>

<script>
    var nav = document.getElementById("welcome");
    var currentRoute = nav.getAttribute('data-route');

    if (currentRoute !== 'admin.dashboard' && currentRoute !== 'guest.page' && currentRoute !== 'home') {
        nav.classList.add("welcome");
    } else {
        nav.classList.remove("welcome");
    }

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

</html>
