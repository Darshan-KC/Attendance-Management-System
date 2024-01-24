<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retrieve company_id from session
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            if ((count(Auth::user()->company)) > 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        $roles = Role::where('company_id',$company_id)->paginate(10);
        return view('attendence.role.main', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('attendence.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|string',
        ]);
        //retrieve company_id from session
        if (session()->has("company_id")) {
            $company_id = session()->get("company_id");
        } else {
            return "else bhitra ayo";
            if ((count(Auth::user()->company)) > 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }

        // Create a new Role instance
        $role = new Role();
        $role->name = strtolower($request->name);
        $role->company_id=$company_id;
        // Save the role to the database
        $role->save();
        notify()->success('Role is assigned Successfully');
        return redirect()->route('role.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
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
        return view('attendence.role.edit', compact('role',''));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:100|string',
        ]);
        $role->name = strtolower($request->name);
        $role->update();
        notify()->success('Role is update Successfully');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!is_null($role)) {
            $role->delete();
            notify()->success('Role has been deleted successfully');
            return redirect()->route('role.index');
        }
        notify()->success('Role not found');
        return redirect()->route('role.index');
    }
}
