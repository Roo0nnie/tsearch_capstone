    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $details['title'] }}</title>
    </head>

    <body>
        <h1>{{ $details['title'] }}</h1>
        <p>{{ $details['body'] }}</p>
        @php
            $route = '';
            if (str_starts_with($user_code, '19')) {
                $route = 'verify.email.admin';
            } elseif (str_starts_with($user_code, '21')) {
                $route = 'verify.email';
            } elseif (str_starts_with($user_code, '20')) {
                $route = 'verify.email.faculty';
            } else {
                $route = 'verify.email.guest';
            }
        @endphp
        <a href="{{ route($route, $user_code) }}"
            style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Verify
            Now</a>
    </body>

    </html>
