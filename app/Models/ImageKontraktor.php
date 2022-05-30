<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageKontraktor extends Model
{
    use HasFactory;
    protected $fillable = [
        'cabangKontraktorId','image'
    ];
    
    public function cabang()
    {
        return $this->belongsTo(KontraktorCabang::class,'cabangKontraktorId','id');
    }
}
