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
