<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticlesEn>
 */
class ArticlesEnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->name(),
            "slug"  => $this->faker->slug(),
            "content" => $this->faker->paragraph(),
            "image" => $this->faker->image(public_path("assets/uploads/thumbnails/articles-en"), 400, 400, null, false, true),
            "meta_desc" => $this->faker->paragraph(),
            "added_by" => 1
        ];
    }
}
