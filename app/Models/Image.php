<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'projectId','image'
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class,'projectId','id');
    }
}
