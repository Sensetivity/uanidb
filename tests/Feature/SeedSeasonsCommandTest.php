<?php

namespace Tests\Feature;

use App\Enums\SeasonOfYearEnum;
use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedSeasonsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_when_from_is_greater_than_to(): void
    {
        $this->artisan('seasons:seed', ['--from' => 2025, '--to' => 2020])
            ->expectsOutputToContain('must be less than or equal')
            ->assertExitCode(1);
    }

    public function test_seeds_seasons_for_year_range(): void
    {
        $this->artisan('seasons:seed', ['--from' => 2020, '--to' => 2021])
            ->expectsOutputToContain('8 seasons processed')
            ->assertExitCode(0);

        $this->assertEquals(8, Season::query()->count());
        $this->assertDatabaseHas('seasons', ['year' => 2020, 'season_of_year' => SeasonOfYearEnum::Winter->value]);
        $this->assertDatabaseHas('seasons', ['year' => 2021, 'season_of_year' => SeasonOfYearEnum::Fall->value]);
    }

    public function test_seeds_single_year(): void
    {
        $this->artisan('seasons:seed', ['--from' => 2000, '--to' => 2000])
            ->expectsOutputToContain('4 seasons processed')
            ->assertExitCode(0);

        $this->assertEquals(4, Season::query()->where('year', 2000)->count());
    }

    public function test_sets_current_season(): void
    {
        $this->artisan('seasons:seed', ['--from' => 2026, '--to' => 2026])
            ->assertExitCode(0);

        $current = Season::query()->where('is_current', true)->first();
        $this->assertNotNull($current);
        $this->assertEquals(2026, $current->year);
    }

    public function test_sets_start_and_end_dates(): void
    {
        $this->artisan('seasons:seed', ['--from' => 2024, '--to' => 2024])
            ->assertExitCode(0);

        $winter = Season::query()
            ->where('year', 2024)
            ->where('season_of_year', SeasonOfYearEnum::Winter)
            ->first();

        $this->assertEquals('2024-01-01', $winter->start_date);
        $this->assertEquals('2024-03-31', $winter->end_date);
    }

    public function test_updates_existing_seasons(): void
    {
        Season::query()->create([
            'year' => 2020,
            'season_of_year' => SeasonOfYearEnum::Winter,
            'is_current' => true,
        ]);

        $this->artisan('seasons:seed', ['--from' => 2020, '--to' => 2020])
            ->expectsOutputToContain('4 seasons processed')
            ->assertExitCode(0);

        // Old is_current should be reset if not the actual current season
        $this->assertEquals(4, Season::query()->where('year', 2020)->count());
    }
}
