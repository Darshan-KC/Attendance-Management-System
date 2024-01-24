<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User;
        $user->name="Sagar Timilsina";
        $user->email="timilsinasagar04@gmail.com";
        $user->password=Hash::make('12345678');
        $user->email_verified_at=Carbon::now();


        $role = Role::where('name', 'super admin')->first();

        if ($role) {
            $user->role_id = $role->id;
            $user->save();
        } else {
            // Handle the case where the role doesn't exist
            // You can create the role here or log an error message.
            // Example: Log::error('Role "super admin" not found');
        }
    }

}
