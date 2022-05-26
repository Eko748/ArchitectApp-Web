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
        Konsultan::create([
            "userId" => 5,
            "telepon" => "088222155847",
            "website" => "eko748.github.io",
            "instagram" => "@anamrepoke_",
            "alamat" => "Cirebon",
            "slug" => "konsultan"
        ]);
    }
}
