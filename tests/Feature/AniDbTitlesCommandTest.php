<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AniDbTitlesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_when_anime_has_no_anidb_id(): void
    {
        Anime::factory()->create(['mal_id' => 200, 'anidb_id' => null]);

        $this->artisan('anidb:import-titles', ['malId' => 200])
            ->expectsOutputToContain('no anidb_id')
            ->assertExitCode(1);
    }

    public function test_fails_when_anime_not_found(): void
    {
        $this->artisan('anidb:import-titles', ['malId' => 99999])
            ->expectsOutputToContain('not found')
            ->assertExitCode(1);
    }

    public function test_fails_without_mal_id_or_all_flag(): void
    {
        $this->artisan('anidb:import-titles')
            ->expectsOutputToContain('Provide a malId argument or use --all flag')
            ->assertExitCode(1);
    }

    public function test_imports_all_anime_with_anidb_id(): void
    {
        Anime::factory()->create(['anidb_id' => 111]);
        Anime::factory()->create(['anidb_id' => 222]);
        Anime::factory()->create(['anidb_id' => null]); // should be skipped

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importAnime')
            ->twice()
            ->andReturn(1);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-titles', ['--all' => true])
            ->expectsOutputToContain('Processed 2 anime')
            ->assertExitCode(0);
    }

    public function test_imports_titles_for_specific_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 100, 'anidb_id' => 555]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importAnime')
            ->once()
            ->with(Mockery::on(fn ($a) => $a->id === $anime->id), false)
            ->andReturn(3);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-titles', ['malId' => 100])
            ->expectsOutputToContain('Imported 3 title(s)')
            ->assertExitCode(0);
    }

    public function test_passes_force_flag(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 300, 'anidb_id' => 999]);

        $mock = Mockery::mock(TitleImportService::class);
        $mock->shouldReceive('importAnime')
            ->once()
            ->with(Mockery::any(), true)
            ->andReturn(2);
        $this->app->instance(TitleImportService::class, $mock);

        $this->artisan('anidb:import-titles', ['malId' => 300, '--force' => true])
            ->assertExitCode(0);
    }
}
