<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileKontraktor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kontraktorId','file'
    ];
    
    public function kontraktor()
    {
        return $this->belongsTo(Kontraktor::class,'kontraktorId','id');
    }
}
