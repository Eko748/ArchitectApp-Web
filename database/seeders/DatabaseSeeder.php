<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();

        $this->call(
            [
                ProjectSeed::class,
                UserSeed::class,
                KontraktorSeed::class,
                OwnerSeed::class,
                AdminSeed::class,
                ProjectOwnerSeed::class,
                KonsultanSeed::class,
                ChooseProjectSeed::class,
                LelangOwnerSeed::class,
                ImageOwnerSeed::class,
                KontrakKerjaKonsultanSeed::class,
                TenderKonsultanSeed::class,
            ]

        );
    }
}
