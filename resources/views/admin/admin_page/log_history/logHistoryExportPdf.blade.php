<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exported Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 90%;
            max-width: 900px;
            border-collapse: collapse;
            margin: 5px auto;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            max-height: 50px;
        }
    </style>
</head>

<body>
    <h1>Users Log</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Name</th>
                <th>Role</th>
                <th>Login</th>
                <th>Logout</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($logs as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->user_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->user_type }}</td>
                    <td>{{ $item->login }}</td>
                    <td>{{ $item->logout }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
