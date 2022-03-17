<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    use HasFactory;

    protected $fillable = [ 'projectId','ownerId'];


    public function project()
    {
        return $this->belongsTo(Project::class,'projectId','id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class,'ownerId','id');
    }
}
