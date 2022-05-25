<?php

namespace Database\Seeders;

use App\Models\ImageOwner;
use Illuminate\Database\Seeder;

class ImageOwnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImageOwner::create([
            "lelangOwnerId" => 1,
            "chooseProjectId" => null,
            "image" => "marvel-2022-05-23-1.jpeg"
        ]);
    }
}
