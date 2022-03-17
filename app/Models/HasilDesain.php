<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilDesain extends Model
{
    use HasFactory;
    protected $fillable =[
        'projectOwnerId','softfile'
    ];

    public function projectOwners()
    {
        return $this->belongsTo(ProjectOwner::class,'projectOwnerId');
    }
}
