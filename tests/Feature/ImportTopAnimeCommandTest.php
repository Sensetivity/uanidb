<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnimeImagesJob;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class ImportTopAnimeCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_dispatches_image_jobs_with_flag(): void
    {
        Queue::fake();

        $anime1 = Anime::factory()->create();
        $anime2 = Anime::factory()->create();

        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importTopAnime')
            ->once()
            ->andReturn([$anime1, $anime2]);
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:top', ['--with-images' => true])
            ->assertExitCode(0);

        Queue::assertPushed(DownloadAnimeImagesJob::class, 2);
    }

    public function test_fails_gracefully_on_exception(): void
    {
        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importTopAnime')
            ->andThrow(new \Exception('Network error'));
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:top')
            ->expectsOutputToContain('Import failed')
            ->assertExitCode(1);
    }

    public function test_imports_top_anime_with_defaults(): void
    {
        $anime = Anime::factory()->create();

        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importTopAnime')
            ->once()
            ->with('tv', 1, false)
            ->andReturn([$anime]);
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:top')
            ->expectsOutputToContain('Successfully imported 1 anime')
            ->assertExitCode(0);
    }

    public function test_passes_type_pages_and_force_options(): void
    {
        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importTopAnime')
            ->once()
            ->with('movie', 5, true)
            ->andReturn([]);
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:top', [
            '--type' => 'movie',
            '--pages' => 5,
            '--force' => true,
        ])->assertExitCode(0);
    }
}
