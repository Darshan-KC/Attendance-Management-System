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
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">User</a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a
                                                    href="javascript:void(0);">User
                                                    Create</a></li>

                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('user.index') }}" data-toggle="modal"
                                                    class="btn btn-primary btn-sm btn-flat">
                                                    <i class="fa-solid fa-eye px-1"></i>View</a>
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
                                                    <div class="col-xxl">
                                                        <div class="card mb-4">
                                                            <div class="card-body">
                                                                <form action="{{ route('user.store') }}" method="POST">
                                                                    @csrf
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-2 col-form-label"
                                                                            for="fullname">Name</label>
                                                                        <div class="col-sm-10">
                                                                            <div class="input-group input-group-merge">
                                                                                <span id="fullname2"
                                                                                    class="input-group-text"><i
                                                                                        class="bx bx-user"></i></span>
                                                                                <input type="text" name="name"
                                                                                    class="form-control" id="fullname"
                                                                                    placeholder="Enter your fullname" value="{{ old('name') }}" />
                                                                            </div>
                                                                            <div class="text-danger m-2">
                                                                                @error('name')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-2 col-form-label"
                                                                            for="email">Email</label>
                                                                        <div class="col-sm-10">
                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text"><i
                                                                                        class="bx bx-envelope"></i></span>
                                                                                <input type="email" name="email"
                                                                                    id="email" class="form-control"
                                                                                    placeholder="Enter your email"  value="{{ old('email') }}"/>
                                                                                <span id="email"
                                                                                    class="input-group-text">@example.com</span>
                                                                            </div>
                                                                            <div class="text-danger m-2">
                                                                                @error('email')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-2 col-form-label"
                                                                            for="password">Password</label>
                                                                        <div class="col-sm-10">
                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text"><i
                                                                                        class="bx bx-key"></i></span>
                                                                                <input type="password" name="password"
                                                                                    id="password" class="form-control" placeholder="Enter your password">
                                                                            </div>
                                                                            <div class="text-danger m-2">
                                                                                @error('password')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label class="col-sm-2 col-form-label"
                                                                            for="email">Role</label>
                                                                        <div class="col-sm-10">
                                                                            <div class="input-group input-group-merge">
                                                                                <span class="input-group-text"><i
                                                                                        class="fa-brands fa-critical-role"></i></span>
                                                                                <select name="role" id="item"
                                                                                    class="form-control">
                                                                                    <option value="">Select a role
                                                                                    </option>
                                                                                    @foreach ($roles as $role)
                                                                                        <option value="{{ $role->id }}">
                                                                                            {{ $role->name }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                                <div class="text-danger m-2">
                                                                                    @error('role')
                                                                                        {{ $message }}
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-end">
                                                                        <div class="col-sm-10">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
