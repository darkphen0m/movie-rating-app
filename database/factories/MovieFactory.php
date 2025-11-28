<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'imdb_id' => 'tt' . fake()->unique()->numberBetween(1000000, 9999999),
            'title' => fake()->sentence(3),
            'year' => (string) fake()->year(),
            'poster_url' => fake()->imageUrl(),
        ];
    }
}
