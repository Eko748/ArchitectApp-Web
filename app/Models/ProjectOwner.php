<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownerId', 'projectId', 'hasil_rab', 'status'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'ownerId', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId', 'id');
    }
    public function kontrak()
    {
        return $this->hasOne(KontrakKerjaKonsultan::class, 'projectOwnerId');
    }
    public function hasil()
    {
        return $this->hasMany(HasilDesain::class, 'projectOwnerId', 'id');
    }
    public function ratings()
    {
        return $this->hasOne(Rating::class, 'projectOwnerId', 'id');
    }

    public function chooseProject()
    {
        return $this->hasOne(ChooseProject::class, 'projectOwnerId', 'id');
    }
    
    public function lelang()
    {
        return $this->hasOne(ImageOwner::class, 'projectOwnerId', 'id');
    }

    public function ambil_image()
    {
        return $this->hasMany(ImageOwner::class, "chooseProjectId", "id");
    }

    public function coba()
    {
        return $this->belongsTo("App\Models\ChooseProject", "id", "projectOwnerId");
    }
    
}
