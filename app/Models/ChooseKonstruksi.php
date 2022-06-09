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


    public function imageOwner()
    { 
        return $this->hasMany("App\Models\ImageOwner", "id", "chooseProjectId");
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
