<?php

namespace Database\Seeders;

use App\Models\KontrakKerjaKonsultan;
use Illuminate\Database\Seeder;

class KontrakKerjaKonsultanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KontrakKerjaKonsultan::create([
            "tenderKonsultanId" => null,
            "projectOwnerId" => 1,
            "kontrakKerja" => "Kontrak Kerja konsultan - owner 2022-05-24.pdf"
        ]);
    }
}
