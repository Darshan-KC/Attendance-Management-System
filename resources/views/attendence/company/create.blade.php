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
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item"><a
                                                    href="javascript:void(0);">Company</a>
                                            </li>
                                            <li class="breadcrumb-item active text-primary"><a href="javascript:void(0);">Company
                                                    Create</a></li>

                                        </ol>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <div class="float-right d-none d-md-block">
                                            <div class="">
                                                <a href="{{ route('company.index') }}" data-toggle="modal"
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

                                                            <form action="{{ route('company.store') }}" method="POST">
                                                                @csrf
                                                             <div class="mb-3">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name">
                                                             </div>
                                                             <input type="hidden" name="creator" value="{{ auth()->user()->id}}">
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


