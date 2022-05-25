<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'kontrakKonsultanId', 'buktiBayar','status'
    // ];
    protected $guarded = [];

    public function kontrak()
    {
        return $this->belongsTo(KontrakKerjaKonsultan::class, 'kontrakKonsultanId','id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'ownerId', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId', 'id');
    }

    public function userOwner()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
