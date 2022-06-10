<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderKontraktor extends Model
{
    use HasFactory;
    use HasFactory;
    // protected $fillable = [
    //     'kontrakKonsultanId', 'buktiBayar','status'
    // ];
    protected $guarded = [];

    public function kontrak()
    {
        return $this->belongsTo(ChooseKonstruksi::class, 'konstruksiOwnerId','id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'ownerId', 'id');
    }
    public function kontraktor()
    {
        return $this->belongsTo(KontraktorCabang::class, 'konstruksiId', 'id');
    }

    public function userOwner()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
