<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\AttendancesExport;
use App\Models\Company;
use App\Models\User;
use App\Models\Manage;
use App\Models\UserCompany;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\NullHandler;
use PDF;

// use Barryvdh\DomPDF\Facade as PDF;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retrieve company_id from session
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }

        // Get the authenticated user
        $user = Auth::user();
        // Initialize the query to get attendance records
        $query = Attendance::query();
        // Check the user's role and customize the query accordingly
        if ($user->role->name === 'admin') {
            // Fetch attendance records for users belonging to the same company
            $attendances = Attendance::whereIn('user_id', function ($query) use ($company_id) {
                $query->select('user_id')->from('user_companies')->where('company_id', $company_id);
            })
                ->orderBy('date', 'desc')
                ->paginate(10);
        } elseif ($user->role->name == "manager") {
            //Fetch attendances records for user and manager belonging to the same company
            $managerId = Auth::user()->role_id;
            $count = Manage::where('manager_id', $managerId)->where('company_id', $company_id)->count();
            if ($count > 1) {
                $attendances = Attendance::whereIn('user_id', function ($query) use ($company_id, $managerId) {
                    $query->select('id')
                        ->from('users')
                        ->whereIn('role_id', function ($subquery) use ($company_id, $managerId) {
                            $subquery->select('servent_id')
                                ->from('manages')
                                ->where('company_id', $company_id)
                                ->where('manager_id', $managerId); // Include the manager's user ID
                        });
                })
                    ->orderBy('date', 'desc')
                    ->paginate(10);

                // return $attendances;
            }
        } else {
            $attendances = $query
                ->where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(15);
        }
        return view('attendence.attendence-record.main', compact('attendances'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        $user = Auth::user();
        $query = Attendance::query();
        if ($user->role->name === 'admin') {
            $attendances = Attendance::whereIn('user_id', function ($sub_query) use ($company_id) {
                $sub_query->select('user_id')->from('user_companies')->where('company_id', $company_id);
            })->get();
            $users = User::whereIn('id', function ($sub_query) use ($company_id) {
                $sub_query->select('user_id')->from('user_companies')->where('company_id', $company_id);
            })->get();
        } else {
            $managerId = Auth::user()->role_id;
            $count = Manage::where('manager_id', $managerId)->where('company_id', $company_id)->count();
            if ($count > 1) {
                $attendances = Attendance::whereIn('user_id', function ($query) use ($company_id, $managerId) {
                    $query->select('id')
                        ->from('users')
                        ->whereIn('role_id', function ($subquery) use ($company_id, $managerId) {
                            $subquery->select('servent_id')
                                ->from('manages')
                                ->where('company_id', $company_id)
                                ->where('manager_id', $managerId); // Include the manager's user ID
                        });
                })
                    ->orderBy('date', 'desc')
                    ->paginate(10);
            }

            $users = User::whereIn('role_id', function ($query) use ($company_id) {
                $query->select('servent_id')
                    ->from('manages')
                    ->where('manager_id', Auth::user()->role_id)
                    ->where('company_id', $company_id)->get();
            })->get();
        }
        return view('attendence.attendence-record.create', compact('attendances', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //   return ('Store ma pasiyo');
        $user_id = $request->input('user_id');
        $attendance = new Attendance();
        $id = $user_id;
        $currentDate = Carbon::today();
        // checking that if user already check in or not
        $check = Attendance::where('user_id', $id)->whereDate('created_at', $currentDate)->first();

        if ($check) {
            notify()->success('You are already check In');
            return redirect()->route('attendance.create');
        } else {
            $company = UserCompany::where('user_id', $id)->first();
            $attendance->user_id = $id;
            $attendance->company_id = $company->company_id;
            $currentTime = Carbon::now();
            $newTime = $currentTime->addHours(5)->addMinutes(45);
            $attendance->check_in = $newTime;
            $attendance->date = $currentTime;
            $attendance->save();
            notify()->success('Check in Successfully');
            return redirect()->route('attendance.create');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        $user_id = $attendance->user_id;
        $attendances = Attendance::where('user_id', $user_id)->get();
        $company = Company::all();
        $user = User::all();
        return view('attendence.attendence-record.view', compact('attendances', 'user', 'company'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // return ('update ma pasiyo');
        // $user_id = $request->user_id;
        $currentDate = Carbon::today();
        $user = Attendance::where('user_id', $id)->whereDate('created_at', $currentDate)->first();
        if ($user->check_out == "") {
            $currentTime = Carbon::now();
            $newTime = $currentTime->addHours(5)->addMinutes(45);
            $user->check_out = $newTime;

            $user->update();
            notify()->success('Check out Successfully');
            return redirect()->route('attendance.create');
        } else {
            notify()->success('You have already checkout');
            return redirect()->route('attendance.create');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function exportAttendance()
    {
        return Excel::download(new AttendancesExport, 'attendances.xlsx');
    }

    public function pdfAttendance()
    {
        $attendances = Attendance::select('attendances.id as SN', 'attendances.created_at as DATE', 'users.name as User_NAME', 'attendances.check_in as TIME IN', 'attendances.check_out as TIME OUT')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->orderBy('attendances.id', 'ASC')
            ->get();

        // Pass the data to a view (you can create a new view file for the PDF content)
        $data = [
            'attendances' => $attendances,
        ];

        $pdf = PDF::loadView('pdf.attendance', $data);

        return $pdf->download('attendance.pdf');
    }


    public function fetchAttendance(Request $request, $id)
    {
        $request->validate([
            'Year' => 'required|numeric',
            'Month' => 'required|numeric|between:1,12',

        ]);

        $selectedYear = $request->input('Year');
        $selectedMonth = $request->input('Month');
        $user_id = $request->input('user_id');
        // Fetch attendance records for the selected year and month
        $attendancesData = Attendance::where('user_id', $user_id)
            ->whereRaw("YEAR(date) = ?", [$selectedYear])
            ->whereRaw("MONTH(date) = ?", [$selectedMonth])
            ->get();
        // Calculate the dates for the header
        $dates = [];
        $currentYear = Carbon::now()->year;
        $startOfMonth = \Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $attendances = $attendancesData;
        while ($startOfMonth <= $endOfMonth) {
            $dates[] = $startOfMonth->format('Y-m-d');
            $startOfMonth->addDay();
        }
        $user = User::find($user_id);
        return view('attendence.attendence-record.view', compact('attendancesData', 'attendances', 'dates', 'selectedYear', 'selectedMonth', 'user'));
    }
}
