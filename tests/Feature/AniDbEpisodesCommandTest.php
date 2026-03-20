<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AniDbEpisodesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_counts_only_successful_imports(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 300, 'anidb_id' => 999]);
        Episode::factory()->count(3)->sequence(
            ['number' => 1],
            ['number' => 2],
            ['number' => 3],
        )->create(['anime_id' => $anime->id]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importEpisode')
            ->times(3)
            ->andReturn(true, false, true);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-episodes', ['malId' => 300])
            ->expectsOutputToContain('Imported 2 episode title(s)')
            ->assertExitCode(0);
    }

    public function test_fails_when_anime_has_no_anidb_id(): void
    {
        Anime::factory()->create(['mal_id' => 200, 'anidb_id' => null]);

        $this->artisan('anidb:import-episodes', ['malId' => 200])
            ->expectsOutputToContain('no anidb_id')
            ->assertExitCode(1);
    }

    public function test_fails_when_anime_not_found(): void
    {
        $this->artisan('anidb:import-episodes', ['malId' => 99999])
            ->expectsOutputToContain('not found')
            ->assertExitCode(1);
    }

    public function test_fails_without_mal_id_or_all_flag(): void
    {
        $this->artisan('anidb:import-episodes')
            ->expectsOutputToContain('Provide a malId argument or use --all flag')
            ->assertExitCode(1);
    }

    public function test_imports_all_anime_with_anidb_id(): void
    {
        $anime1 = Anime::factory()->create(['anidb_id' => 111]);
        $anime2 = Anime::factory()->create(['anidb_id' => 222]);
        Anime::factory()->create(['anidb_id' => null]); // skipped

        Episode::factory()->create(['anime_id' => $anime1->id]);
        Episode::factory()->create(['anime_id' => $anime2->id]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importEpisode')
            ->twice()
            ->andReturn(true);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-episodes', ['--all' => true])
            ->expectsOutputToContain('Processed 2 anime')
            ->assertExitCode(0);
    }

    public function test_imports_episode_titles_for_specific_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 100, 'anidb_id' => 555]);
        Episode::factory()->count(3)->sequence(
            ['number' => 1],
            ['number' => 2],
            ['number' => 3],
        )->create(['anime_id' => $anime->id]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importEpisode')
            ->times(3)
            ->andReturn(true);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-episodes', ['malId' => 100])
            ->expectsOutputToContain('Imported 3 episode title(s)')
            ->assertExitCode(0);
    }
}
