<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relation =new UserCompany();
        $user =  User::where('name','Sagar Timilsina')->first();
        $relation->user_id = $user->id;
        $company = Company::where('created_by','1')->first();
        $relation->company_id = $company->id;
        $relation->save();
    }
}
