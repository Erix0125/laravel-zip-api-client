<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #3b82f6;
            margin: 0 0 5px 0;
            font-size: 24px;
        }

        .header p {
            color: #666;
            margin: 0;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 30px;
            font-size: 10px;
            color: #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background-color: #f3f4f6;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        td {
            border: 1px solid #ddd;
            padding: 10px;
            color: #666;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($counties as $county)
            <tr>
                <td>{{ $county['id'] }}</td>
                <td>{{ $county['name'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} - All Rights Reserved</p>
    </div>
</body>

</html>