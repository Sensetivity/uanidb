<?php

namespace Tests\Feature;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\AnimeDto;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Jobs\DownloadAnimeImagesJob;
use App\Jobs\ImportAnimeJob;
use App\Jobs\ImportCharactersStaffJob;
use App\Jobs\ImportEpisodesJob;
use App\Jobs\ImportVideosJob;
use App\Jobs\TranslateAnimeJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class ImportAnimeJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_always_includes_image_download_in_chain(): void
    {
        Bus::fake([ImportEpisodesJob::class, ImportCharactersStaffJob::class, ImportVideosJob::class, DownloadAnimeImagesJob::class]);

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $animeDto = new AnimeDto(
            malId: 1,
            title: 'Test Anime',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::AIRING,
        );

        $mockProvider->shouldReceive('getAnime')->once()->andReturn($animeDto);
        $mockProvider->shouldNotReceive('getAnimeEpisodes');
        $mockProvider->shouldNotReceive('getAnimeCharacters');
        $mockProvider->shouldNotReceive('getAnimeStaff');
        $mockProvider->shouldNotReceive('getAnimeVideos');

        $job = new ImportAnimeJob(1);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        Bus::assertChained([
            ImportEpisodesJob::class,
            ImportCharactersStaffJob::class,
            ImportVideosJob::class,
            DownloadAnimeImagesJob::class,
        ]);
    }

    public function test_job_does_not_dispatch_chain_when_anime_not_found(): void
    {
        Bus::fake();

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldReceive('getAnime')->once()->with(999)->andReturnNull();

        $job = new ImportAnimeJob(999);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        Bus::assertNothingDispatched();
    }

    public function test_job_includes_translate_when_flag_set(): void
    {
        Bus::fake([ImportEpisodesJob::class, ImportCharactersStaffJob::class, ImportVideosJob::class, DownloadAnimeImagesJob::class, TranslateAnimeJob::class]);

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $animeDto = new AnimeDto(
            malId: 2,
            title: 'Test Anime 2',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::AIRING,
        );

        $mockProvider->shouldReceive('getAnime')->once()->andReturn($animeDto);

        $job = new ImportAnimeJob(2, false, true);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        Bus::assertChained([
            ImportEpisodesJob::class,
            ImportCharactersStaffJob::class,
            ImportVideosJob::class,
            DownloadAnimeImagesJob::class,
            TranslateAnimeJob::class,
        ]);
    }
}
