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
                                        <h4 class="page-title text-left">Role Management</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">Role</a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="javascript:void(0);">Role
                                                    List</a></li>

                                        </ol>
                                    </div>

                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('role.create') }}" data-toggle="modal"
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
                                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th data-priority="1">ID</th>
                                                                        <th data-priority="4">Role Name</th>
                                                                        <th data-priority="7">Actions</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (isset($roles))
                                                                        @foreach ($roles as $role)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $role->name }}</td>
                                                                                <td class="text-center">
                                                                                    {{-- edit model button --}}
                                                                                    <a href="#"
                                                                                        class="btn-sm btn btn-success"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#roleModalEdit_{{ $role->id }}"><i
                                                                                            class="fa fa-edit px-1"></i>Edit</a>


                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="roleModalEdit_{{ $role->id }}"
                                                                                        tabindex="-1" role="dialog"
                                                                                        aria-labelledby="roleModalLabel_{{ $role->id }}"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog  modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="staticBackdropLabel">
                                                                                                        Edit role</h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <form
                                                                                                        action="{{ route('role.update', $role->id) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        @method('put')
                                                                                                        <div class="mb-3">
                                                                                                            <label
                                                                                                                for="name"
                                                                                                                class="form-label">Role
                                                                                                                Name:</label>
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control"
                                                                                                                value="{{ $role->name }}"
                                                                                                                name="name"
                                                                                                                id="name">
                                                                                                            <div
                                                                                                                class="text-danger m-2">
                                                                                                                @error('name')
                                                                                                                    {{ $message }}
                                                                                                                @enderror
                                                                                                            </div>
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
                                                                                    <form
                                                                                        action="{{ route('role.destroy', $role->id) }}"
                                                                                        method="post" class="d-inline">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <button
                                                                                            class="btn btn-danger btn-sm delete btn-flat"
                                                                                            onclick="return confirm('Are you sure to delete ')"><i
                                                                                                class='fa fa-trash'></i>
                                                                                            Delete</button>

                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif


                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="py-1 px-4">
                                                            {{ $roles->links() }}
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
    </div>
@endsection
