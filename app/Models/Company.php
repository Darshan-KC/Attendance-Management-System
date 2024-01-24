<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name','created_by','status'];
    public function attendances(){
        return $this->hasMany(Attendance::class,'company_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function role(){
        return $this->belongsTo(Role::class,'company_id','id');
    }
    public function user_company_relations(){
        return $this->hasMany(UserCompany::class,'company_id','id');
    }
    public function managers(){
        return $this->hasMany(Manage::class,'company_id','id');
    }
    // public function user(){
    //     return $this->belongsTo(User::class,'created_by','id');
    // }
}
