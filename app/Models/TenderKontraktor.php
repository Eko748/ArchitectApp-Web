<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderKontraktor extends Model
{
    use HasFactory;
    protected $fillable = [
        'lelangKonsultanId', 'kontraktorId', 'coverLetter', 'cv', 'status'
    ];
}
