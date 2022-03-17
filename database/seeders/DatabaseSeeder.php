<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Design;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\Owner;
use App\Models\User;
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
            ]

        );
    }
}
