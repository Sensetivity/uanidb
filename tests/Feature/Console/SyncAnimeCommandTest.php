<?php

namespace Tests\Feature\Console;

use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SyncAnimeCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_dispatches_jobs(): void
    {
        Queue::fake();

        Anime::factory()->airing()->neverSynced()->count(3)->create();

        $this->artisan('anime:sync', ['--batch' => 3])
            ->assertSuccessful();
    }

    public function test_command_dry_run_does_not_dispatch(): void
    {
        Queue::fake();

        Anime::factory()->airing()->neverSynced()->count(3)->create();

        $this->artisan('anime:sync', ['--dry-run' => true])
            ->assertSuccessful();

        Queue::assertNothingPushed();
    }

    public function test_command_recalculate_only(): void
    {
        Queue::fake();

        $anime = Anime::factory()->airing()->neverSynced()->create(['sync_priority' => 0]);

        $this->artisan('anime:sync', ['--recalculate' => true])
            ->assertSuccessful();

        $anime->refresh();
        $this->assertGreaterThan(0, $anime->sync_priority);

        Queue::assertNothingPushed();
    }

    public function test_command_respects_batch_size(): void
    {
        Queue::fake();

        Anime::factory()->airing()->neverSynced()->count(5)->create();

        $this->artisan('anime:sync', ['--batch' => 2])
            ->assertSuccessful();
    }

    public function test_command_with_empty_database(): void
    {
        $this->artisan('anime:sync')
            ->assertSuccessful()
            ->expectsOutputToContain('No anime need syncing');
    }
}
