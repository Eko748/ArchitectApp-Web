<?php

namespace Database\Seeders;

use App\Models\Kontraktor;
use Illuminate\Database\Seeder;

class KontraktorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kontraktor::create([
            "userId" => 3
        ]);
    }
}
