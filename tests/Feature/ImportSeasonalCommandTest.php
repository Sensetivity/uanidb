<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ImportSeasonalCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_gracefully_on_exception(): void
    {
        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importSeasonalAnime')
            ->andThrow(new \Exception('API timeout'));
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:seasonal', ['year' => 2024, 'season' => 'winter'])
            ->expectsOutputToContain('Import failed')
            ->assertExitCode(1);
    }

    public function test_imports_seasonal_anime(): void
    {
        $anime1 = Anime::factory()->create();
        $anime2 = Anime::factory()->create();

        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importSeasonalAnime')
            ->once()
            ->with(2024, 'winter', 1, false)
            ->andReturn([$anime1, $anime2]);
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:seasonal', ['year' => 2024, 'season' => 'winter'])
            ->expectsOutputToContain('Successfully imported 2 anime')
            ->assertExitCode(0);
    }

    public function test_passes_force_and_pages_options(): void
    {
        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importSeasonalAnime')
            ->once()
            ->with(2025, 'spring', 3, true)
            ->andReturn([]);
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:seasonal', [
            'year' => 2025,
            'season' => 'spring',
            '--pages' => 3,
            '--force' => true,
        ])->assertExitCode(0);
    }
}
