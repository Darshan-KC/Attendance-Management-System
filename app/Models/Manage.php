<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manage extends Model
{
    use HasFactory;
    protected $fillable=['manager_id','servent_id','company_id'];
    public function manager(){
        return $this->belongsTo(Role::class,'manager_id','id');
    }
    public function servent(){
        return $this->belongsTo(Role::class,'servent_id','id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
