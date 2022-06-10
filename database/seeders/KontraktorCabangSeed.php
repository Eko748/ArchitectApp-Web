<?php

namespace Database\Seeders;

use App\Models\KontraktorCabang;
use App\Models\ImageKontraktor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KontraktorCabangSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cabang = KontraktorCabang::create([
            'nama_tim' => 'Pegasus Interior',
            'description' => 'Tim Kontraktor yang bergerak dibidang konstruksi rumah sesuai desain anda',
            'isLelang' => '0',
            'kontraktorId' => 1,
            'harga_kontrak' => 3000000,
            'jumlah_tim' => 20,
            'alamat_cabang' => 'Jalan Gatot Subroto, Indramayu',
            'slug' => Str::slug('Pegasus Interior'),
        ]);
        $image = [
            [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'e1.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'e2.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'e3.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'e4.jpg'
            ]
        ];
        foreach ($image as $key) {

            ImageKontraktor::create($key);
        }

        $cabang = KontraktorCabang::create([
            'nama_tim' => 'Cahaya Konstruksi',
            'description' => 'Konstruksi dibidang eksterior segala bentuk desain',
            'alamat_cabang' => 'Jalan Tuparev, Cirebon',
            'jumlah_tim' => 30,
            'harga_kontrak' => 4000000,
            'isLelang' => '0',
            'kontraktorId' => 1,
            'slug' => Str::slug('Cahaya Konstruksi'),
        ]);
        $image = [
            [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'a1.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'a2.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'a3.jpg'
            ], [
                'cabangKontraktorId' => $cabang->id,
                'image' => 'a4.jpg'
            ]
        ];
        foreach ($image as $key) {

            ImageKontraktor::create($key);
        }
    }
}
