<?php

namespace Tests\Feature;

use App\Jobs\ImportAniDbEpisodeTitlesJob;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ImportAniDbEpisodeTitlesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_counts_partial_successes(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 5678]);
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

        Log::shouldReceive('info')->zeroOrMoreTimes();

        $job = new ImportAniDbEpisodeTitlesJob($anime->id);
        $job->handle($mock);

        $this->assertDatabaseHas('import_logs', [
            'anime_id' => $anime->id,
            'status' => 3, // Completed
        ]);
    }

    public function test_handles_anime_with_no_episodes(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 9999]);
        // No episodes created

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldNotReceive('importEpisode');
        $this->app->instance(TitleImportService::class, $mock);

        $job = new ImportAniDbEpisodeTitlesJob($anime->id);
        $job->handle($mock);

        $this->assertDatabaseHas('import_logs', [
            'anime_id' => $anime->id,
            'status' => 3, // Completed
        ]);
    }

    public function test_imports_episode_titles(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1234]);
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

        $job = new ImportAniDbEpisodeTitlesJob($anime->id);
        $job->handle($mock);

        $this->assertDatabaseHas('import_logs', [
            'anime_id' => $anime->id,
            'status' => 3, // Completed
        ]);
    }

    public function test_skips_anime_without_anidb_id(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => null]);

        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(fn ($msg) => str_contains($msg, 'no anidb_id'));

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldNotReceive('importEpisode');
        $this->app->instance(TitleImportService::class, $mock);

        $job = new ImportAniDbEpisodeTitlesJob($anime->id);
        $job->handle($mock);
    }

    public function test_skips_when_anime_not_found(): void
    {
        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(fn ($msg) => str_contains($msg, 'not found'));

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldNotReceive('importEpisode');

        $job = new ImportAniDbEpisodeTitlesJob(99999);
        $job->handle($mock);
    }
}
