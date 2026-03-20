<?php

namespace Tests\Feature;

use App\Jobs\ImportAniDbTitlesJob;
use App\Models\Anime;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ImportAniDbTitlesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_imports_titles_for_anime_with_anidb_id(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1234]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importAnime')
            ->once()
            ->with(Mockery::on(fn ($a) => $a->id === $anime->id), false)
            ->andReturn(5);
        $this->app->instance(TitleImportService::class, $mock);

        $job = new ImportAniDbTitlesJob($anime->id);
        $job->handle($mock);

        $this->assertDatabaseHas('import_logs', [
            'anime_id' => $anime->id,
            'status' => 3, // Completed
        ]);
    }

    public function test_passes_force_flag_to_service(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 5678]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importAnime')
            ->once()
            ->with(Mockery::any(), true)
            ->andReturn(2);
        $this->app->instance(TitleImportService::class, $mock);

        $job = new ImportAniDbTitlesJob($anime->id, true);
        $job->handle($mock);
    }

    public function test_skips_anime_without_anidb_id(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => null]);

        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(fn ($msg) => str_contains($msg, 'no anidb_id'));

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldNotReceive('importAnime');
        $this->app->instance(TitleImportService::class, $mock);

        $job = new ImportAniDbTitlesJob($anime->id);
        $job->handle($mock);
    }

    public function test_skips_when_anime_not_found(): void
    {
        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(fn ($msg) => str_contains($msg, 'not found'));

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldNotReceive('importAnime');

        $job = new ImportAniDbTitlesJob(99999);
        $job->handle($mock);
    }
}
