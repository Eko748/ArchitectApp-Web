<?php

namespace Database\Seeders;

use App\Models\LelangOwner;
use Illuminate\Database\Seeder;

class LelangOwnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LelangOwner::create([
            "ownerId" => 1,
            "title" => "Polindra",
            "description" => "The Iron Man",
            "status" => 1,
            "budgetFrom" => 70000,
            "budgetTo" => 50000,
            "gayaDesain" => "modern",
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "5.00",
            "lebar" => "7.00"
        ]);
    }
}
