<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Http\Requests\StorecompanyRequest;
use App\Http\Requests\UpdatecompanyRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            session(['company_id'=> $id]);
            $companies = Company::where('id', $id)->paginate(5);
            $count = Manage::where('manager_id', Auth::user()->role_id)->where('company_id', $id)->count();

            //  Config::set('attendanceSideBar.cnt', $count);
            session(['cnt'=> $count]);
            // return $count;

        } else {
            if (Auth::user()->role->name == 'super admin') {
                $companies = Company::with('user')->paginate(5);
            } else {
                $companies = Company::with('user')->where('created_by', Auth::user()->id)->paginate(5);

            }
            // else {
            //     $companies = Company::whereIn('id', function ($query) {
            //         $query->select('company_id')
            //             ->from('user_companies')
            //             ->where('user_id', Auth::user()->id);
            //     })->paginate(5);
            // }
        }

        return view('attendence.company.main', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendence.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecompanyRequest $request)
    {
        $request->validated();
        $company = new company();
        $company->name = strtoupper($request->name);
        $company->created_by = $request->creator;
        $company->save();
        notify()->success('Mail is sent successfully to the Super admin');
        return redirect()->route('send_mail');
        // return redirect()->route('company.index')->with('success','company created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(company $company)
    {
        // return view('attendence.company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecompanyRequest $request, company $company)
    {
        $request->validated();
        if (!empty($request->name)) {
            $company->name = strtoupper($request->name);
        }
        if (!empty($request->status)) {
            $company->status = $request->status;
        }

        $company->update();
        if ((Auth::user()->role->name == "super admin") && ($company->status == '1')) {
            $member = new UserCompany;
            $member->user_id = $company->created_by;
            $member->company_id = $company->id;
            $member->save();

            $role = new Role;
            $role->name = "admin";
            $role->company_id = $company->id;
            $role->save();
            $user = User::where('id', $company->created_by)->first();
            $user->role_id = $role->id;
            $user->update();
            notify()->success('Company updated Successfully');
            return redirect()->route('admin_mail');
        }
        notify()->success('Company updated Successfully');
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(company $company)
    {
        $company->delete();
        notify()->success('Company has been Deleted');
        return redirect()->route('company.index');
    }
}

