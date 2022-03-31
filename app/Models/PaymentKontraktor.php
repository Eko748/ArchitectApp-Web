<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentKontraktor extends Model
{
    use HasFactory;
    protected $fillable = [
        'kontrakKontraktorId', 'buktiBayar'
    ];
}
