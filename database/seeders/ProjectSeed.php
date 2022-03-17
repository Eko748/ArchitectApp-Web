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
                'image' => 'arsitek.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'arsitek2.jpeg'
            ], [
                'projectId' => $project->id,
                'image' => 'arsitek3.jpg'
            ], [
                'projectId' => $project->id,
                'image' => 'arsitek4.jpeg'
            ]
        ];
        foreach ($image as $key) {

            Image::create($key);
        }
    }
}
