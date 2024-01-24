<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','date', 'company_id','check_in','check_out'
    ];
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
