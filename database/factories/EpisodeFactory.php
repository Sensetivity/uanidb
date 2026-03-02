<?php

namespace Database\Factories;

use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anime_id' => Anime::factory(),
            'mal_id' => fake()->unique()->numberBetween(1, 99999),
            'number' => fake()->numberBetween(1, 24),
            'title' => fake()->sentence(3),
            'title_en' => fake()->sentence(3),
            'aired_unknown' => false,
        ];
    }
}
