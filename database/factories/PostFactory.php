<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Post>
 */
class PostFactory extends Factory
{

    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return void
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'content' => fake()->text,
            'image' => fake()->imageUrl(),
            'like' => random_int(1, 2000),
            'is_published' => 1,
            'category_id' => Category::get()->random()->id,
        ];
    }
}
