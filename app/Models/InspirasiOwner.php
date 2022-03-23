<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspirasiOwner extends Model
{
    use HasFactory;

    protected $fillable = ['lelangOwnerId', 'inspirasi'];

    public function lelang()
    {
        return $this->belongsTo(LelangOwner::class, 'lelangOwnerId', 'id');
    }
}
