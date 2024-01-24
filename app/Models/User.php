<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function attendances(){
        return $this->hasMany(Attendance::class,'user_id','id');
    }
    public function permissions(){
        return $this->hasMany(Permission::class,'user_id','id');
    }
    public function user_company_relations(){
        return $this->hasMany(UserCompany::class,'user_id','id');
    }
    public function company(){
        return $this->hasMany(Company::class,'created_by','id');
    }
    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }
}
