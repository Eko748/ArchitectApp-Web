<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakKerjaKontraktor extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenderKontraktorId', 'konstruksiOwnerId', 'kontrakKerja'
    ];

    public function konstruksiOwner()
    {
        return $this->belongsTo(KonstruksiOwner::class, 'konstrksiOwnerId','id');
    }
    public function payment()
    {
        return $this->hasOne(PaymentKontraktor::class, 'kontrakKontraktorId');
    }
    public function proposal()
    {
        return $this->belongsTo(TenderKonsultan::class, 'tenderKonsultanId');
    }
    public function order()
    {
        return $this->hasOne(OrderKontraktor::class, 'kontrakKontraktorId');
    }
}
