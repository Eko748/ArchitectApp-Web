<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakKerjaKonsultan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenderKonsultanId', 'projectOwnerId','kontrakKerja'
    ];

    public function projectOwner()
    {
        return $this->belongsTo(ProjectOwner::class, 'projectOwnerId','id');
    }
    public function payment()
    {
        return $this->hasOne(PaymentKonsultan::class, 'kontrakKonsultanId');
    }
    public function proposal()
    {
        return $this->belongsTo(TenderKonsultan::class, 'tenderKonsultanId');
    }
}
