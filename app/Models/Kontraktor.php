<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontraktor extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId','telepon','website','instagram','about', 'alamat'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function files()
    {
        return $this->hasMany(FileKontraktor::class, 'kontraktorId');
    }
}
