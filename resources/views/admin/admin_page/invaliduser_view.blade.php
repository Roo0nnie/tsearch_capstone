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
            font-size: 15px
        }

        h1 {
            text-align: center;
        }

        table {
            width: 80%;
            max-width: 900px;
            border-collapse: collapse;
            margin: 10px auto;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: left;
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
    </style>
</head>

<body>
    <h1>Exported Data</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <td>Email</td>
                <td>Phone</td>
                <td>Birthday</td>
                <td>Error</td>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($data as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->user_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->birthday }}</td>
                    <td>{{ $item->error_message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
