<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonstruksiOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownerId', 'konstruksiId', 'konfirmasi', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'ownerId');
    }
    public function konstruksi()
    {
        return $this->belongsTo(KontraktorCabang::class, 'konstruksiId', 'id');
    }
    public function kontrak()
    {
        return $this->hasOne(KontrakKerjaKontraktor::class, 'konstruksiOwnerId');
    }
    public function hasil()
    {
        return $this->hasMany(HasilDesain::class, 'projectOwnerId', 'id');
    }
    public function ratings()
    {
        return $this->hasOne(Rating::class, 'projectOwnerId', 'id');
    }

    public function chooseKonstruksi()
    {
        return $this->hasOne(ChooseKonstruksi::class, 'konstruksiOwnerId', 'id');
    }
    
    // public function lelang()
    // {
    //     return $this->hasOne(ImageOwner::class, 'projectOwnerId', 'id');
    // }

    // public function ambil_image()
    // {
    //     return $this->hasMany(ImageOwner::class, "chooseProjectId", "id");
    // }

    // public function coba()
    // {
    //     return $this->belongsTo("App\Models\ChooseProject", "id", "projectOwnerId");
    // }

}
