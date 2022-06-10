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
            "title" => "Kamar Adem",
            "description" => "Untuk Rumah yang dekat sawah",
            "status" => 1,
            "budgetFrom" => 4000000,
            "budgetTo" => 7000000,
            "gayaDesain" => "traditional",
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "5.00",
            "lebar" => "7.00"
        ]);
        LelangOwner::create([
            "ownerId" => 1,
            "title" => "Kamar Marvel",
            "description" => "Untuk anak laki-laki dan tambahkan juga meja belajar",
            "status" => 0,
            "budgetFrom" => 6000000,
            "budgetTo" => 8000000,
            "gayaDesain" => "modern",
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "7.00",
            "lebar" => "6.00"
        ]);
        LelangOwner::create([
            "ownerId" => 1,
            "title" => "Kamar Rapunzel",
            "description" => "Untuk anak Perempuan yang dilengkapi sudut untuk keamanan",
            "status" => 0,
            "budgetFrom" => 4000000,
            "budgetTo" => 5000000,
            "gayaDesain" => "modern",
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "3.00",
            "lebar" => "5.00"
        ]);
        LelangOwner::create([
            "ownerId" => 2,
            "title" => "Kamar Disney",
            "description" => "Untuk anak Perempuan yang dilengkapi Warna warni",
            "status" => 0,
            "budgetFrom" => 2000000,
            "budgetTo" => 1000000,
            "gayaDesain" => "modern",
            "RAB" => 1,
            "desain" => 1,
            "panjang" => "3.00",
            "lebar" => "5.00"
        ]);
    }
}
