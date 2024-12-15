<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>
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
    <h1>File Data</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Birthday</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @forelse ($users as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->user_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->birthday }}</td>
                    @if ($item->status === 'Active')
                        @if ($item->account_status === 'active')
                            <td>{{ $item->status }}
                            </td>
                        @endif
                    @endif
                    @if ($item->status === 'Inactive')
                        @if ($item->account_status === 'active')
                            <td>{{ $item->status }}
                            </td>
                        @endif
                    @endif
                    @if ($item->account_status === 'blocked')
                        <td>{{ $item->account_status }}
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
