<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'admin_id' => "1",
            'title' => $this->faker->name(),
            'content' => $this->faker->text(),
            'image' => $this->faker->image('public/uploads/blog', 640, 480, null, false),
        ];
    }
}