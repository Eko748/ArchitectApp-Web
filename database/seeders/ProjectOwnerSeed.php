<?php

namespace Database\Seeders;

use App\Models\ProjectOwner;
use Illuminate\Database\Seeder;

class ProjectOwnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectOwner::create([
            "ownerId" => 1,
            "projectId" => 1,
            "status" => "Belum Bayar"
        ]);
    }
}
