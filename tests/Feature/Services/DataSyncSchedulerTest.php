<?php

namespace Tests\Feature\Services;

use App\Enums\AnimeStatusEnum;
use App\Jobs\ImportAnimeJob;
use App\Jobs\ImportEpisodesJob;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\ImportLog;
use App\Models\User;
use App\Models\UserAnimeList;
use App\Services\Sync\DataSyncScheduler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataSyncSchedulerTest extends TestCase
{
    use RefreshDatabase;

    private DataSyncScheduler $scheduler;

    public function test_batch_excludes_currently_running_imports(): void
    {
        $anime1 = Anime::factory()->neverSynced()->create(['sync_priority' => 100]);
        $anime2 = Anime::factory()->neverSynced()->create(['sync_priority' => 90]);

        // Create running import for anime1
        ImportLog::factory()->running()->create([
            'anime_id' => $anime1->id,
            'started_at' => now()->subMinutes(5),
        ]);

        $batch = $this->scheduler->getNextBatch(10);

        $this->assertCount(1, $batch);
        $this->assertEquals($anime2->id, $batch->first()->id);
    }

    public function test_batch_excludes_recently_synced(): void
    {
        // Recently synced (5 minutes ago, under 10 min threshold)
        Anime::factory()->recentlySynced()->create(['sync_priority' => 100]);

        // Not recently synced
        $stale = Anime::factory()->staleSynced()->create(['sync_priority' => 50]);

        $batch = $this->scheduler->getNextBatch(10);

        $this->assertCount(1, $batch);
        $this->assertEquals($stale->id, $batch->first()->id);
    }

    public function test_batch_ordered_by_priority_desc(): void
    {
        $low = Anime::factory()->neverSynced()->create(['sync_priority' => 10]);
        $high = Anime::factory()->neverSynced()->create(['sync_priority' => 100]);
        $medium = Anime::factory()->neverSynced()->create(['sync_priority' => 50]);

        $batch = $this->scheduler->getNextBatch(10);

        $this->assertEquals($high->id, $batch->first()->id);
        $this->assertEquals($low->id, $batch->last()->id);
    }

    public function test_batch_respects_limit(): void
    {
        Anime::factory()->neverSynced()->count(5)->create(['sync_priority' => 50]);

        $batch = $this->scheduler->getNextBatch(3);

        $this->assertCount(3, $batch);
    }

    public function test_determine_jobs_for_airing_anime(): void
    {
        $anime = Anime::factory()->airing()->create([
            'last_synced_at' => now()->subHours(7),
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $jobs = $this->scheduler->determineSyncJobs($anime);

        $this->assertEquals([ImportAnimeJob::class], $jobs);
    }

    public function test_determine_jobs_full_import_for_never_synced(): void
    {
        $anime = Anime::factory()->neverSynced()->create();
        $anime->loadCount(['episodes', 'characters']);

        $jobs = $this->scheduler->determineSyncJobs($anime);

        $this->assertEquals([ImportAnimeJob::class], $jobs);
    }

    public function test_determine_jobs_full_import_for_very_stale(): void
    {
        $anime = Anime::factory()->staleSynced(15)->create();
        $anime->loadCount(['episodes', 'characters']);

        $jobs = $this->scheduler->determineSyncJobs($anime);

        $this->assertEquals([ImportAnimeJob::class], $jobs);
    }

    public function test_determine_jobs_missing_episodes(): void
    {
        $anime = Anime::factory()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'last_synced_at' => now()->subDays(5),
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        // anime has 0 episodes, 0 characters, but we need specific missing data checks
        $jobs = $this->scheduler->determineSyncJobs($anime);

        $this->assertContains(ImportEpisodesJob::class, $jobs);
    }

    public function test_determine_jobs_not_yet_aired_stale(): void
    {
        $anime = Anime::factory()->create([
            'status' => AnimeStatusEnum::NOT_YET_AIRED,
            'last_synced_at' => now()->subDays(4),
            'synopsis' => 'test',
        ]);
        // Add episodes and characters so those checks don't trigger
        Episode::factory()->create(['anime_id' => $anime->id]);
        $character = Character::factory()->create();
        $anime->characters()->attach($character->id, ['role' => 'Main']);
        $anime->loadCount(['episodes', 'characters']);

        $jobs = $this->scheduler->determineSyncJobs($anime);

        $this->assertEquals([ImportAnimeJob::class], $jobs);
    }

    public function test_recalculate_considers_watchlist(): void
    {
        $anime1 = Anime::factory()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'last_synced_at' => now()->subDays(5),
            'synopsis' => 'test',
        ]);
        $anime2 = Anime::factory()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'last_synced_at' => now()->subDays(5),
            'synopsis' => 'test',
        ]);

        // Add watchers to anime1
        $user = User::factory()->create();
        UserAnimeList::factory()->watching()->create([
            'user_id' => $user->id,
            'anime_id' => $anime1->id,
        ]);

        $this->scheduler->recalculateAllPriorities();

        $anime1->refresh();
        $anime2->refresh();

        $this->assertGreaterThan($anime2->sync_priority, $anime1->sync_priority);
    }

    public function test_recalculate_updates_priorities(): void
    {
        $airing = Anime::factory()->airing()->neverSynced()->create();
        $finished = Anime::factory()->recentlySynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);

        $count = $this->scheduler->recalculateAllPriorities();

        $this->assertEquals(2, $count);

        $airing->refresh();
        $finished->refresh();

        $this->assertGreaterThan($finished->sync_priority, $airing->sync_priority);
    }

    public function test_zero_priority_excluded_from_batch(): void
    {
        Anime::factory()->create(['sync_priority' => 0]);

        $batch = $this->scheduler->getNextBatch(10);

        $this->assertEmpty($batch);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->scheduler = $this->app->make(DataSyncScheduler::class);
    }
}
