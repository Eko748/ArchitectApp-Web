<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LelangKonsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenderKonsultanId', 'title', 'description','desain','status'
    ];
}
