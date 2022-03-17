<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId','telepon','alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function lelang()
    {
        return $this->hasMany(LelangOwner::class, 'ownerId', 'id');
    }
    public function projectOwn()
    {
        return $this->hasMany(ProjectOwner::class,'ownerId','id');
    }
    public function favorit()
    {
        return $this->hasMany(Favorit::class,'ownerId','id');
    }
}
