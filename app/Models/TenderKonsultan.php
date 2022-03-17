<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderKonsultan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lelangOwnerId', 'konsultanId', 'coverLetter', 'cv', 'status','tawaranHargaDesain', 'tawaranHargaRab'
    ];
    protected $attributes = [
        'tawaranHargaDesain' => 0,
        'tawaranHargaRab'=> 0
    ];

    public function lelang()
    {
        return $this->belongsTo(LelangOwner::class,'lelangOwnerId','id');
    }
    public function konsultan()
    {
        return $this->belongsTo(Konsultan::class,'konsultanId','id');
    }
    public function kontrak()
    {
        return $this->hasOne(KontrakKerjaKonsultan::class, 'tenderKonsultanId','id');
    }
}
