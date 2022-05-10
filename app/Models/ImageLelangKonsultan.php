<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageLelangKonsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        'LelangKonsultanId','image'
    ];
    
    public function lelangKonsultan()
    {
        return $this->belongsTo(LelangKonsultan::class,'lelangKonsultanId','id');
    }
}
