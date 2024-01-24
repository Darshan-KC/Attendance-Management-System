<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name','company_id'];
    public function users(){
        return $this->hasOne(User::class,'role_id','id');
    }
    public function company(){
        return $this->hasOne(Company::class,'company_id','id');
    }
    public function manager(){
        return $this->hasOne(Role::class,'manager_id','id');
    }
    public function servent(){
        return $this->hasOne(Role::class,'servent_id','id');
    }
}
