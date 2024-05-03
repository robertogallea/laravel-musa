<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach (range(1,20) as $i) {
            Photo::factory()->create([
                'user_id' => $users[rand(0,9)]
            ]);
        }
    }
}
