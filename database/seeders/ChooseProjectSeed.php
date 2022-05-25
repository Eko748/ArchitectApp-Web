<?php

namespace Database\Seeders;

use App\Models\ChooseProject;
use Illuminate\Database\Seeder;

class ChooseProjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChooseProject::create([
            "projectOwnerId" => 1,
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "7.00",
            "lebar" => "7.00"
        ]);
    }
}
