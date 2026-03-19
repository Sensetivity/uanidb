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
     * Indicate that the anime is currently airing.
     */
    public function airing(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => AnimeStatusEnum::AIRING,
            'aired_from' => now()->subMonths(3),
        ]);
    }

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

    /**
     * Indicate that the anime has failed to sync.
     */
    public function failedSync(int $count = 3): static
    {
        return $this->state(fn (array $attributes): array => [
            'last_synced_at' => now()->subDays(1),
            'failed_sync_count' => $count,
        ]);
    }

    /**
     * Indicate that the anime has never been synced.
     */
    public function neverSynced(): static
    {
        return $this->state(fn (array $attributes): array => [
            'last_synced_at' => null,
            'failed_sync_count' => 0,
        ]);
    }

    /**
     * Indicate that the anime was recently synced.
     */
    public function recentlySynced(): static
    {
        return $this->state(fn (array $attributes): array => [
            'last_synced_at' => now()->subMinutes(5),
            'failed_sync_count' => 0,
        ]);
    }

    /**
     * Indicate that the anime sync is stale.
     */
    public function staleSynced(int $daysAgo = 20): static
    {
        return $this->state(fn (array $attributes): array => [
            'last_synced_at' => now()->subDays($daysAgo),
            'failed_sync_count' => 0,
        ]);
    }
}
