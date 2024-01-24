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
                                        <h4 class="page-title text-left">User</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                                            </li>
                                            @if (Auth::user()->role->name == 'user')
                                                <li class="breadcrumb-item active text-primary"><a
                                                        href="{{  route('user.index')}}">User</a>
                                                </li>
                                            @else
                                                <li class="breadcrumb-item "><a href= "{{  route('user.index')}}">User</a>
                                                </li>
                                            @endif
                                            @if (Auth::user()->role->name == 'super admin' || Auth::user()->role->name == 'admin')
                                                <li class="breadcrumb-item active text-primary"><a
                                                        href="{{ route('user.index')}}">User
                                                        List</a></li>
                                            @endif

                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                @if (Auth::user()->role->name == !'super admin' ||
                                                        Auth::user()->role->name == 'admin' ||
                                                        Auth::user()->role->name == !'user')
                                                    <a href="{{ route('user.create') }}" data-toggle="modal"
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
                                                                class="table table-striped table-bordered dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                                <thead>
                                                                    <tr>
                                                                        <th data-priority="1">SN</th>
                                                                        <th data-priority="2">Name</th>
                                                                        <th data-priority="3">Email</th>
                                                                        <th data-priority="4">Role</th>
                                                                        <th data-priority="4">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (isset($users))
                                                                        @foreach ($users as $user)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $user->name }}</td>
                                                                                <td>{{ $user->email }}</td>
                                                                                <td class="text-center"><span class="badge bg-success">{{ $user->role->name }}</span></td>
                                                                                <td>
                                                                                    <!-- Button trigger modal -->

                                                                                    <a href="#"
                                                                                        class="btn-sm btn btn-primary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#userModal_{{ $user->id }}"><i
                                                                                            class="fa fa-eye"></i> View</a>


                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                        id="userModal_{{ $user->id }}"
                                                                                        tabindex="-1" role="dialog"
                                                                                        aria-labelledby="userModalLabel_{{ $user->id }}"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog  modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title"
                                                                                                        id="staticBackdropLabel">
                                                                                                        User</h5>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div
                                                                                                        class="border-bottom m-2">

                                                                                                        <h6> Name:
                                                                                                            <span
                                                                                                                class="p-2">
                                                                                                                {{ $user->name }}
                                                                                                            </span>
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="border-bottom m-2">

                                                                                                        <h6> Email:
                                                                                                            <span
                                                                                                                class="p-2">
                                                                                                                {{ $user->email }}
                                                                                                            </span>
                                                                                                        </h6>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="border-bottom m-2">

                                                                                                        <h6> Role:
                                                                                                            <span
                                                                                                                class="p-2">
                                                                                                                {{ $user->role->name }}
                                                                                                            </span>
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
                                                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                                                        data-toggle="modal"
                                                                                        class="btn btn-success btn-sm edit btn-flat"><i
                                                                                            class='fa fa-edit'></i> Edit</a>
                                                                                    <form
                                                                                        action="{{ route('user.destroy', $user->id) }}"
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
                                                                    @else
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>{{ Auth::user()->name }}</td>
                                                                            <td>{{ Auth::user()->email }}</td>
                                                                            <td>{{ Auth::user()->role->name }}</td>


                                                                            <td>
                                                                                <!-- Button trigger modal -->

                                                                                <a href="#"
                                                                                    class="btn-sm btn btn-primary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#userModal_{{ Auth::user()->id }}"><i
                                                                                        class="fa fa-eye"></i> View</a>


                                                                                <!-- Modal -->
                                                                                <div class="modal fade"
                                                                                    id="userModal_{{ Auth::user()->id }}"
                                                                                    tabindex="-1" role="dialog"
                                                                                    aria-labelledby="userModalLabel_{{ Auth::user()->id }}"
                                                                                    aria-hidden="true">
                                                                                    <div
                                                                                        class="modal-dialog  modal-dialog-centered">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title"
                                                                                                    id="staticBackdropLabel">
                                                                                                    User</h5>
                                                                                                <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div
                                                                                                    class="border-bottom m-2">

                                                                                                    <h6> Name:
                                                                                                        <span
                                                                                                            class="p-2">
                                                                                                            {{ Auth::user()->name }}
                                                                                                        </span>
                                                                                                    </h6>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="border-bottom m-2">

                                                                                                    <h6> Email:
                                                                                                        <span
                                                                                                            class="p-2">
                                                                                                            {{ Auth::user()->email }}
                                                                                                        </span>
                                                                                                    </h6>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="border-bottom m-2">

                                                                                                    <h6> Role:
                                                                                                        <span
                                                                                                            class="p-2">
                                                                                                            {{ Auth::user()->role->name }}
                                                                                                        </span>
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
                                                                                {{-- <a href="{{ route('user.show', $user->id) }}"
                                                                                data-toggle="modal"
                                                                                class="btn btn-primary btn-sm edit btn-flat"><i
                                                                                    class='fa fa-eye px-1'></i>View</a> --}}
                                                                                <a href="{{ route('user.edit', Auth::user()->id) }}"
                                                                                    data-toggle="modal"
                                                                                    class="btn btn-success btn-sm edit btn-flat"><i
                                                                                        class='fa fa-edit'></i> Edit</a>
                                                                                @if (Auth::user()->role->name == 'super admin' || Auth::user()->role->name == 'admin')
                                                                                    <form
                                                                                        action="{{ route('user.destroy', Auth::user()->id) }}"
                                                                                        method="post" class="d-inline">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <button
                                                                                            class="btn btn-danger btn-sm delete btn-flat"
                                                                                            onclick="return confirm('Are you sure to delete ')"><i
                                                                                                class='fa fa-trash'></i>
                                                                                            Delete</button>

                                                                                    </form>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="py-2 px-2">
                                                            @if (isset($users))
                                                                {{ $users->links() }}
                                                            @endif
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
