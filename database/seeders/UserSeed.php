<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Konsultan;
use App\Models\Kontraktor;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar' => 'default.png',
            'is_active' => 1,
            'level' => 'admin'
        ]);
        $admin = Admin::create([
            'userId' => $user->id
        ]);
        $konsultan = User::create([
            'name' => 'konsultan',
            'username' => 'konsultan',
            'email' => 'konsultan@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar' => 'default.png',
            'is_active' => 1,
            'level' => 'konsultan'
        ]);
        $kons = Konsultan::create([
            'userId' => $konsultan->id,
            'slug' => $konsultan->name,
            'telepon' => "085929017480",
            'instagram' => "@kons",
            'website' => "kons.co.id",
            'alamat' => 'Indramayu'
        ]);
        $kontraktor = User::create([
            'name' => 'kontraktor',
            'username' => 'kontraktor',
            'email' => 'kontraktor@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar' => 'default.png',
            'is_active' => 1,
            'level' => 'kontraktor'
        ]);
        $kon = Kontraktor::create([
            'userId' => $kontraktor->id
        ]);

        $owner = User::create([
            'name' => 'owner',
            'username' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('12345678'),
            'avatar' => 'default.png',
            'is_active' => 1,
            'level' => 'owner'
        ]);

        $own = Owner::create([
            'userId' => $owner->id
        ]);
    }
}
