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
                                            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a>
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
                                <div class=" card-header d-flex bg-primary text-white justify-content-between">
                                    <div class="  text-white">
                                        Attendance Sheet Report
                                    </div>
                                    <div>
                                        @if ($attendances->isEmpty())
                                        @else
                                            <p class="text-center text-white">{{ $attendances->first()->user->name }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if ($attendances->isEmpty())
                                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>

                                        <strong>No attendance data is recorded for the selected year and month.</strong>
                                    </div>
                                @endif

                                @if ($attendances->isEmpty())
                                @else
                                    @foreach ($attendances as $attendance)
                                        <form action="{{ route('attendance.fetch', ['id' => $attendance->id]) }}"
                                            method="GET">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $attendance->user->id }}">
                                    @endforeach
                                    <div class="container mt-3">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 ">
                                                <label class="form-label" for="year">Year</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    <select name="Year" class="form-control">
                                                        <option value="">Select a Year</option>
                                                        @php
                                                            $currentYear = date('Y');
                                                            $startYear = $currentYear - 1; // Change this to set the start year
                                                            $endYear = $currentYear + 4; // Change this to set the end year
                                                        @endphp

                                                        @for ($year = $startYear; $year <= $endYear; $year++)
                                                            <option value="{{ $year }}">{{ $year }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="text-danger m-2">
                                                    @error('Year')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-6 ">
                                                <label class="form-label" for="month">Month</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>

                                                    <select name="Month" class="form-control" id="monthSelect">
                                                        <option value="" selected>Select a month</option>
                                                        <!-- Placeholder option -->
                                                        @php
                                                            $currentYear = \Carbon\Carbon::now()->year;
                                                            $currentMonth = \Carbon\Carbon::now()->month;
                                                        @endphp

                                                        @for ($month = 1; $month <= 12; $month++)
                                                            <option value="{{ $month }}">
                                                                {{ \Carbon\Carbon::createFromDate($currentYear, $month, 1)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            var monthSelect = document.getElementById('monthSelect');
                                                            monthSelect.value = '';
                                                        });
                                                    </script>
                                                </div>
                                                <div class="text-danger m-2">
                                                    @error('Month')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                    </form>
                                @endif
                                <div class="card-body mt-2">
                                    <div class="table-responsive table-bordered">
                                        <table class="table">
                                            <thead>

                                                <tr>
                                                    <th class="text-white bg-primary">Date</th>
                                                    @php
                                                        $selectedYear = request('Year');
                                                        $selectedMonth = request('Month');
                                                        if ($selectedYear && $selectedMonth) {
                                                            $today = \Carbon\Carbon::create($selectedYear, $selectedMonth, 1);
                                                        } else {
                                                            $today = today();
                                                        }
                                                        $dates = [];
                                                        for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                                            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                                        }

                                                    @endphp
                                                    @foreach ($dates as $date)
                                                        <th class="bg-primary text-white text-nowrap">
                                                            {{ $date }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">

                                                <tr>
                                                    <td>Check In</td>
                                                    @foreach ($dates as $date)
                                                        <td>
                                                            @php
                                                                $foundAttendance = null;
                                                                foreach ($attendances as $attendance) {
                                                                    if ($attendance->date === $date) {
                                                                        $foundAttendance = $attendance;
                                                                        break; // Exit the loop once we find a matching attendance
                                                                    }
                                                                }
                                                            @endphp

                                                            @if ($foundAttendance)
                                                                <div class="d-flex justify-content-center">
                                                                    <i class="fa fa-check text-success px-2 mt-1"></i>
                                                                    {{ $foundAttendance->check_in }}
                                                                </div>
                                                            @else
                                                                <div class="d-flex justify-content-center">
                                                                    <i class="fas fa-times text-danger"></i>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>

                                                <tr class="">
                                                    <td>Check Out</td>
                                                    @foreach ($dates as $date)
                                                        <td>
                                                            @php
                                                                $foundAttendance = null;
                                                                foreach ($attendances as $attendance) {
                                                                    if ($attendance->date === $date) {
                                                                        $foundAttendance = $attendance;
                                                                        break; // Exit the loop once we find a matching attendance
                                                                    }
                                                                }
                                                            @endphp

                                                            @if ($foundAttendance)
                                                                <div class="d-flex justify-content-center">
                                                                    @if ($foundAttendance->check_out !== null)
                                                                        <i class="fa fa-check text-success px-2 mt-1"></i>
                                                                        {{ $foundAttendance->check_out }}
                                                                    @else
                                                                        <i class="fas fa-times text-danger"></i>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="d-flex justify-content-center">
                                                                    <i class="fas fa-times text-danger"></i>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
