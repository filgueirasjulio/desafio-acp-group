<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['description' => 'Ciência', 'bg_color' => '#a7ffeb'],
            ['description' => 'Política', 'bg_color' => '#f06292'],
            ['description' => 'Vida Saudável', 'bg_color' => '#bbdefb'],
            ['description' => 'Animais', 'bg_color' => '#f9a825'],
            ['description' => 'Música', 'bg_color' => '#80d8ff'],
            ['description' => 'Trabalho', 'bg_color' => '#4caf50'],
            ['description' => 'Dinheiro', 'bg_color' => '#f57c00'],
            ['description' => 'Família', 'bg_color' => '#673ab7'],
            ['description' => 'Educação', 'bg_color' => '#1e88e5'],
            ['description' => 'Tecnologia', 'bg_color' => '#d32f2f'],
            ['description' => 'Viagens', 'bg_color' => '#388e3c'],
            ['description' => 'Filmes', 'bg_color' => '#7b1fa2'],
            ['description' => 'Literatura', 'bg_color' => '#c2185b'],
            ['description' => 'Esportes', 'bg_color' => '#0288d1'],
            ['description' => 'Fotografia', 'bg_color' => '#8e24aa'],
        ];

        foreach($data as $item) {
            $tag = Tag::where('description', $item['description'])->first();

            if(!$tag) {
                Tag::create([
                    'description' => $item['description'],
                    'slug' => Str::slug($item['description']),
                    'bg_color' => $item['bg_color']
                ]);
            }
        }
    }
}
