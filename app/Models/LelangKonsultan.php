<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangKonsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenderKonsultanId', 'title', 'description','budget','desain','rab','status'
    ];

    public function tenderKonsultan()
    {
        return $this->belongsTo(TenderKonsultan::class, 'tenderKonsultanId', 'id');
    }

    public function proposal()
    {
        return $this->hasMany(TenderKonsultan::class, 'lelangOwnerId');
    }
}


