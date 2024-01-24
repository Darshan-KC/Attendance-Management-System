<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Manage;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use App\Http\Controllers\notify;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Excel;

class UserController extends Controller
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
            if (count(Auth::user()->company) != 0) {
                $company_id = Auth::user()->company->id;
            } else {
                $company_id = 0;
            }
        }
        if (Auth::user()->role->name == 'user' || Auth::user()->role->name == 'company user') {
            return view('attendence.user.main');
        } else {
            // Super admin la herna milni users haru dekhauni ho.
            if (Auth::user()->role->name == 'super admin') {
                //role  admin vayeka id jati roles table bata taannera $adminRoleIds layera array ma rakhne
                $adminRoleIds = Role::where('name', 'admin')->pluck('id');
                $superAdminRoleId = Role::where('name', 'super admin')->value('id');

                $users = User::where(function ($query) use ($adminRoleIds, $superAdminRoleId) {
                    $query->whereIn('role_id', $adminRoleIds)
                        ->orWhere('role_id', $superAdminRoleId)
                        ->orWhere('role_id', Role::where('name', 'user')->where('company_id', 0 )->value('id'));
                })->distinct()->paginate(10);
            } elseif (Auth::user()->role->name == 'admin') {
                // Role admin cha bhani, tesko session ma store bha ko company ko users haru dekhauni
                $users = User::whereIn('id', function ($query) use ($company_id) {
                    $query->select('user_id')
                        ->from('user_companies')
                        ->where('company_id', $company_id);
                })->paginate(10);
            } else {
                //if user la kosailai manager gardaina bhani usko matra data dekhauni ho arko herna rokna parcha
                $count = Manage::where('manager_id', Auth::user()->role_id)->where('company_id', $company_id)->count();

                if ($count > 1) {
                    $users = User::whereIn('role_id', function ($query) use ($company_id) {
                        $query->select('servent_id')
                            ->from('manages')
                            ->where('manager_id', Auth::user()->role_id)
                            ->where('company_id', $company_id)->get();
                    })->paginate(10);
                } else {
                    $users = User::where('id', Auth::user()->id)->paginate(10);
                }
            }

            return view('attendence.user.main', compact('users'));
        }
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
        $roles = Role::where('company_id', $company_id)->get();
        return view('attendence.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|max:16|min:8'
        ]);
        $id = Auth::user()->id;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = $request->password;
        $user->save();

        $company_id = session()->get('company_id');
        $user_company = new UserCompany();
        $user_company->user_id = $user->id;
        $user_company->company_id = $company_id;
        $user_company->save();

        notify()->success('User is created successfully');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::find($id);
        return view('attendence.user.view', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
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
        $roles = Role::where('company_id', $company_id)->get();
        return view('attendence.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'max:100',
            'email' => ['email'],
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->update();
        notify()->success('User is updated Successfully');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
        if (!is_null($user)) {
            $user->delete();
            notify()->success('User is deleted successfully');
            return redirect()->route('user.index');
        }
        notify()->success('User not found');
        return redirect()->route('user.index');
    }
    public function exportUser()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
