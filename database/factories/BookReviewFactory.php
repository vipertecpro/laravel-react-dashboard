<?php

namespace Database\Factories;

use App\Models\BookReview;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BookReview>
 */
class BookReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'content'   => fake()->paragraphs(random_int(5,10),true),
            'rating'    => fake()->numberBetween(1,5),
            'status'    => fake()->randomElement([
                'under_process',
                'approved',
            ])
        ];
    }
}
