<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultan extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId', 'telepon', 'website', 'instagram', 'about', 'alamat', 'slug'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function files()
    {
        return $this->hasMany(FileKonsultan::class, 'konsultanId');
    }
    public function projects()
    {
        return $this->hasMany(Project::class, 'konsultanId');
    }
    public function proposal()
    {
        return $this->hasOne(TenderKonsultan::class, 'konsultanId', 'id');
    }
}
