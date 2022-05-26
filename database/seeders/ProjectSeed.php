<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Project::create([
            'title' => 'Ao Nobara',
            'description' => 'Sebuah desain arsitektur minimalist dan anggun dengan sentuhan mawar biru yang cantik nan jelita',
            'isLelang' => '0',
            'konsultanId' => 1,
            'harga_desain' => 5000000,
            'harga_rab' => 1000000,
            'gayaDesain' => 'Minimalist',
            'slug' => Str::slug('Ao Nobara'),
        ]);
        $image = [
            [
                'projectId' => $project->id,
                'image' => 'e1.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'e2.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'e3.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'e4.jpg'
            ]
        ];
        foreach ($image as $key) {

            Image::create($key);
        }

        $project = Project::create([
            'title' => 'Mawar Alami',
            'description' => 'Sebuah desain arsitektur traditional yang memancarkan keindahan bunga Mawar',
            'isLelang' => '0',
            'konsultanId' => 2,
            'harga_desain' => 2000000,
            'harga_rab' => 4000000,
            'gayaDesain' => 'traditional',
            'slug' => Str::slug('Mawar Alami'),
        ]);
        $image = [
            [
                'projectId' => $project->id,
                'image' => 'a1.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'a2.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'a3.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'a4.jpg'
            ]
        ];
        foreach ($image as $key) {

            Image::create($key);
        }
    }
}
