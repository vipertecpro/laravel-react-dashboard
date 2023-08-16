<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $getTitle = fake()->words(5,true);
        return [
            'title' => $getTitle,
            'subtitle' => $getTitle,
            'slug' => Str::slug($getTitle),
            'description' => fake()->sentences(2, true),
            'ISBN_10' => Str::random(10),
            'ISBN_13' => Str::random(13),
            'price' => fake()->numberBetween(30,3000),
            'author_id' => 0,
            'publisher_id' => 0,
            'stock_quantity' => fake()->numberBetween(1,10),
            'status' => fake()->randomElement(['available', 'out_of_stock', 'coming_soon']),
            'weight' => fake()->numberBetween(1,10),
            'width' => fake()->numberBetween(1,10),
            'height' => fake()->numberBetween(1,10),
            'depth' => fake()->numberBetween(1,10),
            'language' => fake()->randomElement(["English",
                "Hindi",
                "Spanish",
                "French",
                "German",
                "Chinese",
                "Japanese",
                "Russian"]),
            'publication_date' => fake()->dateTime(),
            'is_preorder' => fake()->randomElement([true,false]),
            'binding_type' => fake()->randomElement(['Paper Back','Hard Cover','Others']),
            'number_of_pages' => fake()->numberBetween(5,10000),
            'created_by' => 0
        ];
    }
}
