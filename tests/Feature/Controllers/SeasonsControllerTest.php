<?php

namespace Tests\Feature\Controllers;

use App\Enums\SeasonOfYearEnum;
use App\Models\Anime;
use App\Models\Season;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_accepts_type_filter(): void
    {
        $season = Season::factory()->create(['is_current' => true]);

        $this->get(route('seasons', ['type' => 'tv']))
            ->assertOk();
    }

    public function test_index_accepts_year_and_season_parameters(): void
    {
        $season = Season::factory()->create([
            'year' => 2025,
            'season_of_year' => SeasonOfYearEnum::Winter,
        ]);

        $this->get(route('seasons', ['year' => 2025, 'season' => 'winter']))
            ->assertOk()
            ->assertViewHas('season');
    }

    public function test_index_falls_back_to_latest_season(): void
    {
        Season::factory()->create(['year' => 2024, 'season_of_year' => SeasonOfYearEnum::Fall, 'is_current' => false]);

        $this->get(route('seasons'))
            ->assertOk()
            ->assertViewHas('season');
    }

    public function test_index_returns_ok_with_current_season(): void
    {
        $season = Season::factory()->create(['is_current' => true]);

        $this->get(route('seasons'))
            ->assertOk()
            ->assertViewHas('season');
    }

    public function test_index_returns_ok_with_no_seasons(): void
    {
        $this->get(route('seasons'))
            ->assertOk();
    }

    public function test_index_shows_season_anime(): void
    {
        $season = Season::factory()->create(['is_current' => true]);
        $anime = Anime::factory()->create();
        $season->animes()->attach($anime->id);

        $response = $this->get(route('seasons'));
        $response->assertOk();

        $viewAnimes = $response->viewData('animes');
        $this->assertCount(1, $viewAnimes);
    }
}
