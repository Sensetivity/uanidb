<?php

namespace Database\Factories;

use App\Enums\ThemeType;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mal_title' => fake()->unique()->word(),
            'name' => fake()->unique()->word(),
            'type' => fake()->randomElement(ThemeType::cases()),
        ];
    }
}
