<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Attendance;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return Attendance::select('attendances.id as SN', 'attendances.created_at as DATE', 'users.name as User_NAME', 'attendances.check_in as TIME IN', 'attendances.check_out as TIME OUT')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'SN',
            'DATE',
            'User_NAME',
            'TIME IN',
            'TIME OUT',
        ];
    }

    public function map($row): array
    {
        return [
            $row->SN,
            date('Y-m-d', strtotime($row->DATE)),
            $row->User_NAME,
            $row->{'TIME IN'},
            $row->{'TIME OUT'},
        ];
    }
}

// use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use App\Models\Attendance;

// class AttendancesExport implements FromQuery, WithHeadings
// {
//     use Exportable;

//     public function query()
//     {
//         return \App\Models\Attendance::query()
//         ->select('attendances.id as SN', 'attendances.created_at as DATE', 'users.name as User_NAME', 'attendances.check_in as TIME IN', 'attendances.check_out as TIME OUT')
//         ->join('users', 'users.id', '=', 'attendances.user_id');
//     }

//     public function headings(): array
//     {
//         return [
//             'SN',
//             'DATE',
//             'User_NAME',
//             'TIME IN',
//             'TIME OUT',
//         ];
//     }
// }
