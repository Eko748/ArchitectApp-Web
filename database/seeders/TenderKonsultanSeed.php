<?php

namespace Database\Seeders;

use App\Models\TenderKonsultan;
use Illuminate\Database\Seeder;

class TenderKonsultanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TenderKonsultan::create([
            "lelangOwnerId" => 1,
            "konsultanId" => 1,
            "coverLetter" => "Tema Marvel",
            "cv" => "konsultan-2022-05-24.jpg",
            "tawaranHargaDesain" => 4000000,
            "tawaranHargaRab" => 5000000,
            "status" => 1


        ]);
    }
}
