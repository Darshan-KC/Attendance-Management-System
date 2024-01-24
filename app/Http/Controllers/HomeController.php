<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manage;

class HomeController extends Controller
{
    public function index(){
        return view('attendence.home');
        // $count = Manage::where('manager_id', Auth::user()->role_id)->where('company_id', $company_id)->count();

        //         if ($count > 1) {
        //             $users = User::whereIn('role_id', function ($query) use ($company_id) {
        //                 $query->select('servent_id')
        //                     ->from('manages')
        //                     ->where('manager_id', Auth::user()->role_id)
        //                     ->where('company_id', $company_id)->get();
        //             })->paginate(10);}
    }
    public function show(){
        return view('attendence.attendence-record.main');
    }
    public function create(){
        return view('attendence.attendence-record.create');
    }
}
