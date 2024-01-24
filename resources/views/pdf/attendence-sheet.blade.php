<!DOCTYPE html>
<html>
<head>
    <title>Attendance Sheet Report</title>
    <style>
        /* Define your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
        }

        th {
            background-color: #3490dc;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Attendance Sheet Report</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                @foreach($dates as $date)
                    <th>{{ $date }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Check In</td>
                @foreach($dates as $date)
                    <td>
                        @if ($attendance->date === $date)
                            <i class="fa fa-check text-success"></i> {{ $attendance->check_in }}
                        @else
                            <i class="fas fa-times text-danger"></i>
                        @endif
                    </td>
                @endforeach
            </tr>
            <tr>
                <td>Check Out</td>
                @foreach($dates as $date)
                    <td>
                        @if ($attendance->date === $date)
                            <i class="fa fa-check text-success"></i> {{ $attendance->check_out }}
                        @else
                            <i class="fas fa-times text-danger"></i>
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>
