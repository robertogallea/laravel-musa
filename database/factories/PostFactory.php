<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->text(32),
            'slug' => Str::of($title)->slug()->toString(),
            'body' => $this->faker->realText(2000),
            'user_id' => null,
            'category_id' => Category::first()->id,
            'status' => rand(0,1),
        ];
    }
}
