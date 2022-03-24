<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable =[
        'rating','projectOwnerId'
    ];

    public function projectOwner() 
    {
        return $this->belongsTo(ProjectOwner::class, 'projectOwnerId');
    }
}
