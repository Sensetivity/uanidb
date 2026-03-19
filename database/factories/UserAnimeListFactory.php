<?php

namespace Database\Factories;

use App\Enums\WatchlistStatusEnum;
use App\Models\Anime;
use App\Models\User;
use App\Models\UserAnimeList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAnimeList>
 */
class UserAnimeListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'anime_id' => Anime::factory(),
            'status' => fake()->randomElement(WatchlistStatusEnum::cases()),
            'episode_progress' => fake()->numberBetween(0, 24),
        ];
    }

    /**
     * Indicate that the user is planning to watch.
     */
    public function planToWatch(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => WatchlistStatusEnum::PLAN_TO_WATCH,
            'episode_progress' => 0,
        ]);
    }

    /**
     * Indicate that the user is watching.
     */
    public function watching(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => WatchlistStatusEnum::WATCHING,
        ]);
    }
}
