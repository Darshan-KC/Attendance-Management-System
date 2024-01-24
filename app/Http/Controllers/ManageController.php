<?php

namespace App\Http\Controllers;

use App\Models\Manage;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   //retrieve company_id from session
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        $roles = Role::where('company_id',$company_id)->get();
        $manages = Manage::with('manager','servent')->where('company_id',$company_id)->paginate(10);
        return view('attendence.manage.main',compact('manages','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //retrieve company_id from session
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        $roles = Role::where('company_id',$company_id)->get();
        return view('attendence.manage.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        $manage = new Manage();
        $manage->manager_id = $request->srole;
        $manage->servent_id = $request->role;
        $manage->company_id = $company_id;
        $manage->save();
        notify()->success('Created Successfully');
        return redirect()->route('manage.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manage $manage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manage $manage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manage $manage)
    {
        $manage->manager_id = $request->srole;
        $manage->servent_id = $request->role;
        $manage->update();
        notify()->success('Updated Successfully');
        return redirect()->route('manage.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manage $manage)
    {
        $manage->delete();
        notify()->success('Deleted Successfully');
        return redirect()->route('manage.index');
    }
}
