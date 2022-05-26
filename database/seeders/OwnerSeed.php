<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Seeder;

class OwnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Owner::create([
            "userId" => 4,
            "telepon" => "12345",
            "alamat" => "Cirebon"
        ]);

        Owner::create([
            "userId" => 6,
            "telepon" => "0888888888991",
            "alamat" => "Cirebon"
        ]);
    }
}
