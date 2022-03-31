<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileKonsultan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'konsultanId','file'
    ];
    
    public function konsultan()
    {
        return $this->belongsTo(Konsultan::class,'konsultanId','id');
    }
}
