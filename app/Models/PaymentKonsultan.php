<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentKonsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kontrakKonsultanId', 'buktiBayar','status'
    ];

    public function kontrak()
    {
        return $this->belongsTo(KontrakKerjaKonsultan::class, 'kontrakKonsultanId','id');
    }
}
