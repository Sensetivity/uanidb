<?php

namespace Database\Factories;

use App\Enums\SeasonOfYearEnum;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->unique()->numberBetween(1950, 2100),
            'season_of_year' => fake()->randomElement(SeasonOfYearEnum::cases()),
            'is_current' => false,
        ];
    }
}
