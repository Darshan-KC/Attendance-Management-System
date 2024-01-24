<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Attendance Data</h1>
    <table>
        <thead>
            <tr>
                <th>SN</th>
                <th>DATE</th>
                <th>User NAME</th>
                <th>TIME IN</th>
                <th>TIME OUT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->SN }}</td>
                <td>{{ date('Y-m-d', strtotime($attendance->DATE)) }}</td>
                <td>{{ $attendance->{'User_NAME'} }}</td>
                <td>{{ $attendance->{'TIME IN'} }}</td>
                <td>{{ $attendance->{'TIME OUT'} }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
