<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontraktorCabang extends Model
{
    use HasFactory;
    protected $fillable = [
        'kontraktorId', 'nama_tim', 'description', 'alamat_cabang', 'slug', 'jumlah_tim', 'harga_kontrak', 'isLelang'
    ];
    protected $attributes = [
        'harga_kontrak' => 0
    ];

    public function images()
    {
        return $this->hasMany(ImageKontraktor::class,'cabangKontraktorId');
    }

    public function kontraktor()
    {
        return $this->belongsTo(Kontraktor::class, 'kontraktorId', 'id');
    }

    public function konstruksiOwn()
    {
        return $this->hasMany(KonstruksiOwner::class,'konstruksiId','id');
    }
}
