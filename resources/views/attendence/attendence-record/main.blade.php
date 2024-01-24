@extends('attendence.layouts.main')
@section('title', 'Attendance Management System')
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
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="{{ route('attendance.index') }}">Attendance</a></li>
                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end ">
                                        <div class="float-right d-md-block ">
                                            <div class=" d-flex justify-content-end">
                                                @if (Auth::user()->role->name !== 'user')
                                                    <a href="{{ route('attendance.create') }}">
                                                        <button class="btn btn-primary btn-sm btn-flat">
                                                            <i class="fa-solid fa-plus px-1 "></i>Attendance</button></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="m-2 mx-0">
                                                        <a href="{{ route('export-pdfs') }}"
                                                            class="btn btn-primary btn-sm btn-flat m-1"><i
                                                                class="mdi mdi-plus mr-2"></i> PDF</a>
                                                        <a href="{{ route('export-attendance') }}"
                                                            class="btn btn-primary btn-sm btn-flat m-1"><i
                                                                class="mdi mdi-plus mr-2"></i> Excel</a>
                                                    </div>
                                                    <div class="table-rep-plugin">
                                                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                                                            <table id="datatable-buttons"
                                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                <thead>
                                                                    <tr>

                                                                        <th data-priority="1">SN</th>
                                                                        <th data-priority="1">Date</th>
                                                                        <th data-priority="3">Name</th>
                                                                        <th data-priority="3">Position/Role</th>
                                                                        <th data-priority="6">Time In</th>
                                                                        <th data-priority="7">Time Out</th>
                                                                        <th data-priority="7">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $currentDate = now()->toDateString();
                                                                        $currentTime = now(); // Get the current date as a string
                                                                        $currentDateTime = now(); // Get the current date and time

                                                                        // Add 5 hours and 45 minutes
                                                                        $newDateTime = $currentDateTime->addHours(5)->addMinutes(45);

                                                                        // Extract the date and time components separately
                                                                        $newDate = $newDateTime->toDateString();
                                                                    @endphp
                                                                    @foreach ($attendances as $attendance)
                                                                        {{-- @if ($attendance->date === $newDate) --}}
                                                                            @if (auth()->check())
                                                                                @if (auth()->user()->role->name === 'admin' && $attendance->user_id && $attendance->user->role->name !== 'super admin')
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td>{{ $attendance->date }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->user->name }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->user->role->name }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->check_in }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($attendance->check_out === null)
                                                                                                <p class="text-danger">
                                                                                                    Not Checked Out</p>
                                                                                            @else
                                                                                                {{ $attendance->check_out }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            <a href="{{ route('attendance.show', $attendance->id) }}"
                                                                                                data-toggle="modal"
                                                                                                class="btn btn-primary btn-sm edit btn-flat"><i
                                                                                                    class='fa fa-eye px-1'></i>View</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->date }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->user->name }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->user->role->name }}
                                                                                        </td>
                                                                                        <td>{{ $attendance->check_in }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if ($attendance->check_out === null)
                                                                                                <p class="text-danger">
                                                                                                    Not Checked Out</p>
                                                                                            @else
                                                                                                {{ $attendance->check_out }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            <a href="{{ route('attendance.show', $attendance->id) }}"
                                                                                                data-toggle="modal"
                                                                                                class="btn btn-primary btn-sm edit btn-flat"><i
                                                                                                    class='fa fa-eye px-1'></i>View</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        {{-- @endif --}}
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="py-1 px-4">
                                                    @if (isset($attendances))
                                                        {{ $attendances->links() }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
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
