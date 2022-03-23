<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'lelangOwnerId', 'image', 'chooseProjectId'
    ];

    public function lelang()
    {
        return $this->belongsTo(LelangOwner::class, 'lelangOwnerId');
    }
    public function choose()
    {
        return $this->belongsTo(ChooseProject::class, 'chooseProjectId', 'id');
    }
}
