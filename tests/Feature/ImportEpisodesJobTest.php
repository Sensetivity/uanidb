<?php

namespace Tests\Feature;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\EpisodeDto;
use App\Jobs\ImportEpisodesJob;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ImportEpisodesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_imports_episodes_for_existing_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldReceive('getAnimeEpisodes')
            ->once()
            ->with(10)
            ->andReturn([
                new EpisodeDto(malId: 1, number: 1, title: 'Episode 1'),
                new EpisodeDto(malId: 2, number: 2, title: 'Episode 2'),
            ]);

        $job = new ImportEpisodesJob($anime->id);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertEquals(2, $anime->episodes()->count());
    }

    public function test_job_skips_when_anime_not_found(): void
    {
        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldNotReceive('getAnimeEpisodes');

        $job = new ImportEpisodesJob(999);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertTrue(true);
    }
}
