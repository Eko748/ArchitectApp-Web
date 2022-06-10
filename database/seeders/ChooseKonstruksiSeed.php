<?php

namespace Database\Seeders;

use App\Models\ChooseKonstruksi;
use Illuminate\Database\Seeder;

class ChooseKonstruksiSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChooseKonstruksi::create([
            "konstruksiOwnerId" => 1,
            "kota" => "Indramayu",
            "kecamatan" => "Sindang",
            "desa" => "Sindang",
            "jalan" => "Jalan oto Iskandar",
            "mulaiKonstruksi" => "2022-06-2",
            "RAB" => "rab.pdf",
            "desain" => "desain.pdf",
            "status" => 1
        ]);
    }
}
