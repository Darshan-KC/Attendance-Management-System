<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role=new Role;
        $role->name='super admin';
        $role->company_id=0;
        $role->save();
        $role=new Role;
        $role->name='user';
        $role->company_id=0;
        $role->save();
    }
}
