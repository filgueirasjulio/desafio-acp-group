<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserAndPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
     public function run()
     {
         $admin = User::create([
             'name' => 'Júlio',
             'email' => 'julio@mail.com',
             'email_verified_at' => now(),
             'password' => Hash::make('senha123'),
             'remember_token' => Str::random(10),
         ]);
 
         User::factory(5)->create();

         $users = User::all();

         $users->each(function (User $user) {
            for ($i = 0; $i < rand(2, 3); $i++) {
                $post = Post::factory()->create([
                    'user_id' => $user->id,
                ]);
                $post->tags()->attach(rand(1, 5));
            }
        });
     }
}
