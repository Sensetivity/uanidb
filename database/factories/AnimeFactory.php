<?php

namespace Database\Factories;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Anime>
 */
class AnimeFactory extends Factory
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
            'title' => fake()->sentence(3),
            'type' => fake()->randomElement(AnimeTypeEnum::cases()),
            'status' => fake()->randomElement(AnimeStatusEnum::cases()),
            'aired_unknown' => false,
        ];
    }
}
