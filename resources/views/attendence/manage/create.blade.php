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
                                        <h4 class="page-title text-left">Manage Role</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a
                                                    href="javascript:void(0);">manage</a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a href="javascript:void(0);">Company
                                                    List</a></li>

                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('manage.index') }}" data-toggle="modal"
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
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <form action="{{ route('manage.store') }}" method="POST">
                                                                @csrf
                                                                <div class="row mb-3">
                                                                    <label class="col-sm-2 col-form-label"
                                                                        for="email">Manage by</label>
                                                                    <div class="col-sm-10">
                                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text"><i
                                                                                    class="fa-brands fa-critical-role"></i></span>
                                                                            <select name="srole" id="item"
                                                                                class="form-control">
                                                                                <option value="">select role</option>
                                                                                @foreach ($roles as $role)

                                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                                </option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label class="col-sm-2 col-form-label"
                                                                        for="email">To Manage</label>
                                                                    <div class="col-sm-10">
                                                                        <div class="input-group input-group-merge">
                                                                            <span class="input-group-text"><i
                                                                                    class="fa-brands fa-critical-role"></i></span>
                                                                            <select name="role" id="item"
                                                                                class="form-control">
                                                                                <option value="">select role</option>
                                                                                @foreach ($roles as $role)

                                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                                </option>
                                                                                @endforeach

                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                           <button type="submit" class="btn btn-primary">Create</button>


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
@endsection


