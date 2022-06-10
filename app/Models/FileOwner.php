<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileOwner extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 'chooseKonstruksiId'
    ];

    public function lelang()
    {
        return $this->belongsTo(LelangOwner::class, 'lelangOwnerId');
    }
    public function choose()
    {
        return $this->belongsTo(ChooseKonstruksi::class, 'chooseKonstruksiId', 'id');
    }
}
