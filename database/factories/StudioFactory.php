<?php

namespace Database\Factories;

use App\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Studio>
 */
class StudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mal_id' => fake()->unique()->numberBetween(1, 99999),
            'name' => fake()->unique()->company(),
            'slug' => fake()->unique()->slug(),
        ];
    }
}
