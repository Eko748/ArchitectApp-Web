<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangKonsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'konsultanId', 'title', 'description', 'slug', 'budget','status'
        'tenderKonsultanId', 'title', 'description','desain','status'
    ];
    // protected $attributes = [
    //     'budget' => 0,
    // ];

    public function images()
    {
        return $this->hasMany(ImageLelangKonsultan::class,'LelangKonsultanId');
    }

    public function files()
    {
        return $this->hasOne(FileLelangKonsultan::class,'lelangKonsultanId');
    }

    public function konsultan()
    {
        return $this->belongsTo(Konsultan::class, 'konsultanId', 'id');
    }

    public function tenderKonsultan()
    {
        return $this->belongsTo(TenderKonsultan::class, 'tenderKonsultanId', 'id');
    }

    public function proposal()
    {
        return $this->hasMany(TenderKonsultan::class, 'lelangOwnerId');
    }
}


