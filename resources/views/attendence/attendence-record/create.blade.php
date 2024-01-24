@extends('attendence.layouts.main')
@section('title', 'Attendence Management System')
@section('main-section')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-12 mb-4 order-0">
                            <div class="col-sm-12">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <h4 class="page-title text-left">Attendance</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('attendance.index') }}">Attendance</a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="javascript:void(0);">Attendance
                                                    Sheet Report</a></li>
                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('attendance.index') }}" data-toggle="modal"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fa-solid fa-arrow-left px-1"></i>Return Back </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-white bg-primary">SN</th>
                                                    <th class="text-white bg-primary">Name</th>
                                                    <th class="text-white bg-primary">Position</th>
                                                    @php
                                                        $today = today();
                                                        $dates = [];
                                                        $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month)->addHours(5)->addMinutes(45)->format('Y-m-d');
                                                    @endphp
                                                    @foreach ($dates as $date)
                                                        <th class="text-nowrap text-white bg-primary text-center">
                                                            {{ $date }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->role->name }}</td>

                                                        <td class="text-center">
                                                            <div>
                                                                @php
                                                                    $currentDate = now()->toDateString();
                                                                    $currentTime = now(); // Get the current date as a string
                                                                    $currentDateTime = now(); // Get the current date and time

                                                                    // Add 5 hours and 45 minutes
                                                                    $newDateTime = $currentDateTime->addHours(5)->addMinutes(45);

                                                                    // Extract the date and time components separately
                                                                    $newDate = $newDateTime->toDateString(); // Get only the date
                                                                    $newTime = $newDateTime->format('H:i');
                                                                    $userAttendance = $attendances
                                                                        ->where('user_id', $user->id)
                                                                        ->where('date', $newDate)
                                                                        ->sortBy('check_in')
                                                                        ->first();
                                                                @endphp
                                                                @if ($userAttendance)
                                                                    @php
                                                                        $attendanceDate = $userAttendance->date; // Get the attendance date from the database
                                                                    @endphp
                                                                    {{-- AttendanceDate = {{ $attendanceDate }} --}}
                                                                    @if ($attendanceDate == $newDate && !$userAttendance->check_out)
                                                                        <form
                                                                            action="{{ route('attendance.update', $user->id) }}"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ $user->id }}">
                                                                            <div>
                                                                                <button  onclick="return confirm('Are you want to Check Out')"
                                                                                    class="btn btn-danger btn-sm btn-flat"
                                                                                    type="submit"> <i
                                                                                        class="fa-solid fa-times px-1"></i>Check
                                                                                    Out</button>
                                                                            </div>
                                                                        </form>
                                                                        {{-- @endif --}}
                                                                    @elseif ($attendanceDate == $newDate && $userAttendance->check_out)
                                                                        <!-- User has checked in and checked out today, show "Done" button -->
                                                                        <a href="#"
                                                                            class="btn btn-success btn-sm btn-flat">
                                                                            <i class="fa-solid fa-check px-1"></i>Done
                                                                        </a>
                                                                    @else
                                                                        <!-- User hasn't checked in today, show "Check In" button -->

                                                                        <form action="{{ route('attendance.store') }}"
                                                                            method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ $user->id }}">
                                                                            <div>
                                                                                <button  onclick="return confirm('Are you want to Check In')"
                                                                                    class="btn btn-primary btn-sm btn-flat"
                                                                                    value=""> <i
                                                                                        class="fa-solid fa-plus px-1"></i>Check
                                                                                    In</button>

                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                @else
                                                                    <!-- User hasn't checked in today, show "Check In" button -->

                                                                    <form action="{{ route('attendance.store') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $user->id }}">
                                                                        <div>
                                                                            <button  onclick="return confirm('Are you want to Check In')""

                                                                            class="btn btn-primary btn-sm btn-flat"
                                                                                value="">
                                                                                <i class="fa-solid fa-plus px-1"></i>Check
                                                                                In
                                                                            </button>

                                                                        </div>
                                                                    </form>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                    {{-- <pre>
                                                        date::  {{ $currentDate }}
                                                        currentytime :: {{ $currentTime }}
                                                        newDate::{{   $newDate }}
                                                        newTime::{{ $newTime }}
                                                    </pre> --}}
                                                @endforeach
                                                </form>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="notify">
                                @include('notify::components.notify')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
