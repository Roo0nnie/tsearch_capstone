<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notification</title>
    <!-- Inline CSS for email clients -->
    <style>
        /* General reset */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-header {
            background-color: #253e58;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .email-body {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 0 0 5px 5px;
        }

        .email-footer {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h3>Email from: {{ $data['user_email'] }}</h3>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <p><strong>Message:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p>If you have any questions, feel free to <a href="mailto:{{ $data['user_email'] }}">reply to this
                    email</a>.</p>
        </div>
    </div>
</body>

</html>
