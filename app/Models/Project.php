<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'konsultanId', 'title', 'description', 'slug', 'gayaDesain','harga_rab','harga_desain','isLelang'
    ];
    protected $attributes = [
        'harga_rab' => 0,
        'harga_desain' => 0
    ];

    public function images()
    {
        return $this->hasMany(Image::class,'projectId');
    }

    public function konsultan() 
    {
        return $this->belongsTo(Konsultan::class, 'konsultanId', 'id');
    }

    public function designStyle()
    {
        return $this->hasMany(DesainStyle::class,'projectId','id');
    }
    public function projectOwn()
    {
        return $this->hasMany(ProjectOwner::class,'projectId','id');
    }

    public function favorit()
    {
        return $this->hasOne(Favorit::class,'projectId','id');
    }
}
