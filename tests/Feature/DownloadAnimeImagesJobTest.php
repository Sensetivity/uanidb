<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnimeImagesJob;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DownloadAnimeImagesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_continues_after_single_image_failure(): void
    {
        $anime = Anime::factory()->create([
            'source_image_url' => 'https://invalid-domain-that-does-not-exist.test/image.jpg',
        ]);

        Log::shouldReceive('warning')
            ->atLeast()
            ->once();

        Log::shouldReceive('info')->withAnyArgs()->zeroOrMoreTimes();

        $job = new DownloadAnimeImagesJob($anime->id);
        $job->handle();

        $this->assertCount(0, $anime->fresh()->getMedia('main_poster'));
    }

    public function test_job_handles_non_existent_anime_gracefully(): void
    {
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'not found');
            });

        Log::shouldReceive('info')->zeroOrMoreTimes();

        $job = new DownloadAnimeImagesJob(999999);
        $job->handle();
    }

    public function test_job_skips_anime_with_no_source_image_url(): void
    {
        $anime = Anime::factory()->create(['source_image_url' => null]);

        $job = new DownloadAnimeImagesJob($anime->id);
        $job->handle();

        $this->assertCount(0, $anime->getMedia('main_poster'));
    }
}
