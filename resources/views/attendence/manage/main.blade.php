@extends('attendence.layouts.main')
@section('title', 'Attendence Management System ')
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
                                        <h4 class="page-title text-left">Manage</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Manage </a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="javascript:void(0);">Manage
                                                    List</a></li>

                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('manage.create') }}" data-toggle="modal"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fa-solid fa-plus px-1"></i>Add</a>
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
                                                                        <th data-priority="1">S.N</th>
                                                                        <th data-priority="2">Managed by</th>
                                                                        <th data-priority="2">To manage</th>
                                                                        <th data-priority="7">Actions</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (isset($manages))
                                                                        @foreach ($manages as $manage)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $manage->manager->name }}</td>
                                                                                <td>{{ $manage->servent->name }}</td>
                                                                                <td>
                                                                                    <!-- Button trigger modal -->

                                                                                    <a href="#"
                                                                                        class="btn-sm btn btn-primary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#ManageModal_{{ $manage->id }}"><i
                                                                                            class="fa fa-eye"></i> View</a>


                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="ManageModal_{{ $manage->id }}"
                                                                                        tabindex="-1" role="dialog"
                                                                                        aria-labelledby="companyModalLabel_{{ $manage->id }}"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog  modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="staticBackdropLabel">
                                                                                                       Manage View</h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div
                                                                                                        class="border-bottom">

                                                                                                        <h6>Managed By:
                                                                                                            <span>
                                                                                                                {{ $manage->manager->name }}
                                                                                                            </span>
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="border-bottom py-3">

                                                                                                        <h6>To Manage:<span>
                                                                                                                {{ $manage->servent->name }}</span>
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
                                                                                    <a href="#"
                                                                                    class="btn-sm btn btn-success"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#ManageModalEdit_{{ $manage->id }}"><i
                                                                                        class="fa fa-edit"></i>Edit</a>


                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="ManageModalEdit_{{ $manage->id }}"
                                                                                        tabindex="-1" role="dialog"
                                                                                        aria-labelledby="ManageModalLabel_{{ $manage->id }}"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog  modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="staticBackdropLabel">
                                                                                                        Edit </h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <form
                                                                                                        action="{{ route('manage.update', $manage->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        @method('put')
                                                                                                        <div class="mb-3">
                                                                                                            <label
                                                                                                                for=""
                                                                                                                class="form-label">Managed
                                                                                                                By</label>
                                                                                                            <select
                                                                                                                class="form-select form-select-lg"
                                                                                                                name="srole"
                                                                                                                id="">
                                                                                                                <option
                                                                                                                    selected>
                                                                                                                    Select
                                                                                                                    role
                                                                                                                </option>
                                                                                                                @foreach ($roles as $role)
                                                                                                                    <option
                                                                                                                        value="{{ $role->id }}">
                                                                                                                        {{ $role->name }}
                                                                                                                    </option>
                                                                                                                @endforeach

                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="mb-3">
                                                                                                            <label
                                                                                                                for=""
                                                                                                                class="form-label">Managed
                                                                                                                To</label>
                                                                                                            <select
                                                                                                                class="form-select form-select-lg"
                                                                                                                name="role"
                                                                                                                id="">
                                                                                                                <option
                                                                                                                    selected>
                                                                                                                    Select
                                                                                                                    role
                                                                                                                </option>
                                                                                                                @foreach ($roles as $role)
                                                                                                                    <option
                                                                                                                        value="{{ $role->id }}">
                                                                                                                        {{ $role->name }}
                                                                                                                    </option>
                                                                                                                @endforeach

                                                                                                            </select>
                                                                                                        </div>



                                                                                                        <div
                                                                                                            class="modal-footer">
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn btn-primary"
                                                                                                                >submit</button>
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
                                                                                    <form
                                                                                        action="{{ route('manage.destroy', $manage->id) }}"
                                                                                        method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <button type="submit"
                                                                                            onclick="return confirm('are you want to delete')"
                                                                                            class="btn btn-danger btn-sm btn-flat"><i
                                                                                                class="fa fa-trash"></i>
                                                                                            Delete</button>
                                                                                    </form>

                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <div>Hello</div>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                            <div class="py-2">

                                                                {{ $manages->links() }}
                                                            </div>
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
