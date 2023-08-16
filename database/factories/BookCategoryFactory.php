<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookCategory>
 */
class BookCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $getTitle = fake()->words(random_int(3,10),true);
        return [
            'name' => $getTitle,
            'slug' => Str::slug($getTitle),
            'description' => fake()->sentences(2, true),
            'is_active' => fake()->randomElement([0,1]),
        ];
    }
}
