<?php

namespace Tests\Feature;

use App\Jobs\ImportCharactersStaffJob;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class ImportCharactersCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_dispatches_job_with_queue_flag(): void
    {
        Queue::fake();
        $anime = Anime::factory()->create(['mal_id' => 200]);

        $this->artisan('import:characters', ['malId' => 200, '--queue' => true])
            ->expectsOutputToContain('Dispatched')
            ->assertExitCode(0);

        Queue::assertPushed(ImportCharactersStaffJob::class);
    }

    public function test_fails_gracefully_on_service_exception(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 300]);

        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importCharactersAndStaff')
            ->once()
            ->andThrow(new \Exception('API error'));
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:characters', ['malId' => 300])
            ->expectsOutputToContain('Import failed')
            ->assertExitCode(1);
    }

    public function test_fails_when_anime_not_found(): void
    {
        $this->artisan('import:characters', ['malId' => 99999])
            ->expectsOutputToContain('not found')
            ->assertExitCode(1);
    }

    public function test_imports_characters_for_existing_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 100]);

        $mock = Mockery::mock(AnimeImportService::class);
        $mock->shouldReceive('importCharactersAndStaff')
            ->once()
            ->with(Mockery::on(fn ($a) => $a->id === $anime->id));
        $this->app->instance(AnimeImportService::class, $mock);

        $this->artisan('import:characters', ['malId' => 100])
            ->expectsOutputToContain('Successfully imported')
            ->assertExitCode(0);
    }
}
