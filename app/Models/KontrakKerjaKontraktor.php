<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakKerjaKontraktor extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenderKontraktorId', 'KontrakKerja'
    ];
}
