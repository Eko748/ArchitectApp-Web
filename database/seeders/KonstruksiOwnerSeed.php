<?php

namespace Database\Seeders;

use App\Models\KonstruksiOwner;
use Illuminate\Database\Seeder;

class KonstruksiOwnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KonstruksiOwner::create([
            "ownerId" => 4,
            "konstruksiId" => 1,
            "konfirmasi" => "0",
            "status" => "0"
        ]);
    }
}
