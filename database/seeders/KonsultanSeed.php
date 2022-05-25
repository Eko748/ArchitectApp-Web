<?php

namespace Database\Seeders;

use App\Models\Konsultan;
use Illuminate\Database\Seeder;

class KonsultanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Konsultan::create([
            "userId" => 2,
            "telepon" => 1234567,
            "website" => "kons.co.id",
            "instagram" => "@kons",
            "alamat" => "Bandung",
            "slug" => "konsultan"
        ]);
    }
}
