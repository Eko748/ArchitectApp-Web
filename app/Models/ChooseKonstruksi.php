<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChooseKonstruksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'konstruksiOwnerId', 'kota', 'kecamatan', 'desa', 'jalan', 'mulaiKonstruksi', 'RAB', 'desain', 'status'
    ];


    public function fileOwner()
    { 
        return $this->hasMany(FileOwner::class, "id", "chooseKonstruksiId");
    }
    public function konstruksiOwner()
    {
        return $this->belongsTo(KonstruksiOwner::class, 'konstruksiOwnerId');
    }

    public function ambil()
    {
        return $this->hasMany("App\Models\ImageOwner", "id" , "chooseProjectId");
    }
}
