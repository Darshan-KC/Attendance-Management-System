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
                                        <h4 class="page-title text-left">Company</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                                            </li>

                                            @if(Auth::user()->role->name == 'user')
                                            <li class="breadcrumb-item active text-primary"><a href="{{ route('company.index') }}">Company</a>
                                            </li>
                                            @else
                                            <li class="breadcrumb-item"><a href="{{ route('company.index') }}">Company</a></li>
                                            </li>
                                            @endif
                                            @if(Auth::user()->role->name == 'super admin' || (Auth::user()->role->name == 'admin'))
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="javascript:void(0);">Company List</a></li>
@endif
                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                @if ((Auth::user()->role->name !== 'super admin') || (Auth::user()->role->name == 'admin') || (Auth::user()->role->name == 'user'))
                                                    <a href="{{ route('company.create') }}" data-toggle="modal"
                                                        class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fa-solid fa-plus px-1"></i>Add</a>
                                                @endif
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
                                                            <table id="datatable-buttons"
                                                                class="table table-striped table-bordered dt-responsive nowrap text-center"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                                <thead>
                                                                    <tr>
                                                                        <th data-priority="1">Company ID</th>
                                                                        <th data-priority="2">Name</th>
                                                                        <th data-priority="2">Created_by</th>
                                                                        <th data-priority="2">Status</th>
                                                                        <th data-priority="7">Actions</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (isset($companies))
                                                                        @foreach ($companies as $company)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $company->name }}</td>
                                                                                <td>{{ $company->user->name }}</td>
                                                                                <td>
                                                                                    <span class="badge bg-{{$company->status?'success':'warning'}}">
                                                                                    {{ $company->status ? 'Approve' : 'Not Approve' }}
                                                                                </span></td>
                                                                                <td>
                                                                                    <!-- Button trigger modal -->

                                                                                    <a href="#"
                                                                                        class="btn-sm btn btn-primary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#companyModal_{{ $company->id }}"><i
                                                                                            class="fa fa-eye"></i> View</a>


                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="companyModal_{{ $company->id }}"
                                                                                        tabindex="-1" role="dialog"
                                                                                        aria-labelledby="companyModalLabel_{{ $company->id }}"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog  modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="staticBackdropLabel">
                                                                                                        Company</h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div
                                                                                                        class="border-bottom">

                                                                                                        <h6>Company Name:
                                                                                                            <span>
                                                                                                                {{ $company->name }}
                                                                                                            </span>
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="border-bottom py-3">

                                                                                                        <h6>Created By:<span
                                                                                                                id="createdBy">{{ $company->user->name }}</span>
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-secondary"
                                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @if (Auth::user()->role->name == 'super admin' || Auth::user()->role->name == 'admin')
                                                                                        {{-- edit model button --}}
                                                                                        @if (Auth::user()->role->name == 'super admin')
                                                                                            <form
                                                                                                action="{{ route('company.update', $company->id) }}"
                                                                                                method="POST"
                                                                                                class="d-inline-block">
                                                                                                @csrf
                                                                                                @method('PUT')
                                                                                                <input type="number"
                                                                                                    name="status"
                                                                                                    value="1" hidden>
                                                                                                @if ($company->status == '0')

                                                                                                <button type="submit" onclick="return confirm('are you want to approve')"
                                                                                                    class="btn btn-sm btn-success">Approve</button>
                                                                                                @endif
                                                                                            </form>
                                                                                        @else
                                                                                            <a href="#"
                                                                                                class="btn-sm btn btn-success"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#companyModalEdit_{{ $company->id }}"><i
                                                                                                    class="fa fa-edit px-1"></i>Edit</a>


                                                                                            <!-- Modal -->
                                                                                            <div class="modal fade"
                                                                                                id="companyModalEdit_{{ $company->id }}"
                                                                                                tabindex="-1"
                                                                                                role="dialog"
                                                                                                aria-labelledby="companyModalLabel_{{ $company->id }}"
                                                                                                aria-hidden="true">
                                                                                                <div
                                                                                                    class="modal-dialog  modal-dialog-centered">
                                                                                                    <div
                                                                                                        class="modal-content">
                                                                                                        <div
                                                                                                            class="modal-header">
                                                                                                            <h5 class="modal-title"
                                                                                                                id="staticBackdropLabel">
                                                                                                                Edit Company
                                                                                                            </h5>
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn-close"
                                                                                                                data-bs-dismiss="modal"
                                                                                                                aria-label="Close"></button>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="modal-body">
                                                                                                            <form
                                                                                                                action="{{ route('company.update', $company->id) }}"
                                                                                                                method="POST">
                                                                                                                @csrf
                                                                                                                @method('put')
                                                                                                                <div
                                                                                                                    class="mb-3">
                                                                                                                    <label
                                                                                                                        for="name"
                                                                                                                        class="form-label">Company
                                                                                                                        Name:</label>
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        class="form-control"
                                                                                                                        value="{{ $company->name }}"
                                                                                                                        name="name"
                                                                                                                        id="name">
                                                                                                                </div>


                                                                                                                <div
                                                                                                                    class="modal-footer">
                                                                                                                    <button
                                                                                                                        type="submit"
                                                                                                                        class="btn btn-primary"
                                                                                                                        data-bs-dismiss="modal">Submit</button>
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="btn btn-secondary"
                                                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                                                </div>
                                                                                                            </form>

                                                                                                        </div>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        <form
                                                                                            action="{{ route('company.destroy', $company->id) }}"
                                                                                            method="POST"
                                                                                            class="d-inline">
                                                                                            @csrf
                                                                                            @method('delete')
                                                                                            <button type="submit"
                                                                                                onclick="return confirm('are you want to delete')"
                                                                                                class="btn btn-danger btn-sm btn-flat"><i
                                                                                                    class="fa fa-trash"></i>
                                                                                                Delete</button>
                                                                                        </form>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <div>Hello</div>
                                                                    @endif
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="py-2 px-4">
                                                            {{ $companies->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
