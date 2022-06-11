<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'level',
        'last_login',
        'avatar',
        'is_active',
        'fireBaseToken',
        'last_seen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->hasOne(Owner::class,'userId');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class,'userId');
    }
    public function konsultan()
    {
        return $this->hasOne(Konsultan::class,'userId');
    }
    public function kontraktor()
    {
        return $this->hasOne(Kontraktor::class,'userId');
    }
    public function project()
    {
        return $this->hasMany(Project::class,'konsultanId');
    }
    
}
