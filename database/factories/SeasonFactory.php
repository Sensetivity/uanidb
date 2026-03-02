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
        $seasonOfYear = fake()->randomElement(SeasonOfYearEnum::cases());
        $year = fake()->numberBetween(2000, 2026);

        return [
            'name' => $seasonOfYear->getLabel() . ' ' . $year,
            'year' => $year,
            'season_of_year' => $seasonOfYear,
            'is_current' => false,
        ];
    }
}
