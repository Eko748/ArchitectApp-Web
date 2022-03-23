<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChooseProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'projectOwnerId', 'RAB', 'desain', 'panjang', 'lebar'
    ];

    protected $attribute = [
        'RAB' => "0", 'desain' => "0"
    ];

    public function imageOwner()
    {
        return $this->hasMany(ImageOwner::class, 'chooseProjectId');
    }
    public function projectOwner()
    {
        return $this->belongsTo(ProjectOwner::class, 'projectOwnerId');
    }
}
