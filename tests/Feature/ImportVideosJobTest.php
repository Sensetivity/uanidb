<?php

namespace Tests\Feature;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\PromotionVideoDto;
use App\Jobs\ImportVideosJob;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ImportVideosJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_imports_videos(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldReceive('getAnimeVideos')
            ->once()
            ->with(10)
            ->andReturn([
                new PromotionVideoDto(title: 'PV 1', videoUrl: 'https://example.com/pv1'),
            ]);

        $job = new ImportVideosJob($anime->id);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertEquals(1, $anime->promotionVideos()->count());
    }

    public function test_job_skips_when_anime_not_found(): void
    {
        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldNotReceive('getAnimeVideos');

        $job = new ImportVideosJob(999);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertTrue(true);
    }
}
