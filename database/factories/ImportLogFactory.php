<?php

namespace Database\Factories;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\ImportLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImportLog>
 */
class ImportLogFactory extends Factory
{
    /**
     * Indicate that the import log is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ImportStatusEnum::Completed,
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
            'error_message' => null,
        ]);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(ImportStatusEnum::cases());

        return [
            'job_type' => fake()->randomElement(ImportJobTypeEnum::cases()),
            'mal_id' => fake()->numberBetween(1, 99999),
            'status' => $status,
            'started_at' => $status !== ImportStatusEnum::Pending ? now()->subMinutes(5) : null,
            'completed_at' => in_array($status, [ImportStatusEnum::Completed, ImportStatusEnum::Failed]) ? now() : null,
            'error_message' => $status === ImportStatusEnum::Failed ? fake()->sentence() : null,
        ];
    }

    /**
     * Indicate that the import log has failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ImportStatusEnum::Failed,
            'started_at' => now()->subMinutes(5),
            'completed_at' => now(),
            'error_message' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the import log is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ImportStatusEnum::Pending,
            'started_at' => null,
            'completed_at' => null,
            'error_message' => null,
        ]);
    }

    /**
     * Indicate that the import log is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ImportStatusEnum::Running,
            'started_at' => now()->subMinutes(2),
            'completed_at' => null,
            'error_message' => null,
        ]);
    }
}
