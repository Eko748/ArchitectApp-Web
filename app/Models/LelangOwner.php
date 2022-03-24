<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownerId', 'title', 'description', 'desain', 'status', 'budget', 'RAB', 'kontraktor', 'budgetFrom', 'budgetTo', 'gayaDesain', 'panjang', 'lebar'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'ownerId', 'id');
    }
    public function proposal()
    {
        return $this->hasMany(TenderKonsultan::class, 'lelangOwnerId');
    }
    public function image()
    {
        return $this->hasMany(ImageOwner::class, 'lelangOwnerId', 'id');
    }
    public function inspirasi()
    {
        return $this->hasMany(InspirasiOwner::class, 'lelangOwnerId', 'id');
    }
}
