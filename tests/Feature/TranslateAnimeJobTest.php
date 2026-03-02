<?php

namespace Tests\Feature;

use App\Jobs\TranslateAnimeJob;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\Translation\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class TranslateAnimeJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_translates_anime_synopsis(): void
    {
        $anime = Anime::factory()->create([
            'synopsis' => 'An exciting adventure anime.',
            'synopsis_uk' => null,
        ]);

        $mockService = Mockery::mock(TranslationService::class);
        $mockService->shouldReceive('translateAnimeSynopsis')
            ->once()
            ->with(Mockery::on(fn ($a) => $a->id === $anime->id))
            ->andReturnTrue();

        $job = new TranslateAnimeJob($anime->id, withEpisodes: false);
        $job->handle($mockService);
    }

    public function test_job_translates_anime_and_episodes(): void
    {
        $anime = Anime::factory()->create([
            'synopsis' => 'A story about heroes.',
            'synopsis_uk' => null,
        ]);

        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Episode 1',
            'title_en' => 'The Start',
            'title_uk' => null,
            'synopsis' => null,
            'synopsis_uk' => null,
        ]);

        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 2,
            'title' => 'Episode 2',
            'title_en' => 'The Battle',
            'title_uk' => 'Битва',
            'synopsis' => null,
            'synopsis_uk' => null,
        ]);

        $mockService = Mockery::mock(TranslationService::class);
        $mockService->shouldReceive('translateAnimeSynopsis')->once()->andReturnTrue();
        $mockService->shouldReceive('translateEpisode')->once()->andReturnTrue();

        $job = new TranslateAnimeJob($anime->id, withEpisodes: true);
        $job->handle($mockService);
    }

    public function test_job_skips_when_anime_not_found(): void
    {
        $mockService = Mockery::mock(TranslationService::class);
        $mockService->shouldNotReceive('translateAnimeSynopsis');

        $job = new TranslateAnimeJob(999);
        $job->handle($mockService);
    }
}
