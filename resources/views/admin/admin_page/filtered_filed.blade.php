<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File SDG</title>
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
                <th>ID</th>
                <th>Category</th>
                <th>Title</th>
                <th>Author</th>
                <th>Adviser</th>
                <th>Abstract</th>
                <th>Department</th>
                <th>Date</th>
                <th>Call #</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @forelse ($imrads as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->adviser }}</td>
                    <td>{{ $item->abstract }}</td>
                    <td>{{ $item->department }}</td>
                    <td>{{ $item->publication_date }}</td>
                    <td>{{ $item->location }}</td>
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
