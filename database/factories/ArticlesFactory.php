<?php

namespace Database\Factories;

use App\Models\Articles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticlesFactory extends Factory
{

    protected $model = Articles::class;
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
            "image" => $this->faker->image(public_path("assets/uploads/thumbnails/articles-ar"), 400, 400,null,false,true),
            "meta_desc" => $this->faker->paragraph(),
            "added_by" => 1
        ];
    }
}
