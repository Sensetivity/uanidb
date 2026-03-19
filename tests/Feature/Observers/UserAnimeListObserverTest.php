<?php

namespace Tests\Feature\Observers;

use App\Enums\WatchlistStatusEnum;
use App\Models\Anime;
use App\Models\User;
use App\Models\UserAnimeList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAnimeListObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_completed_status_does_not_increment(): void
    {
        $anime = Anime::factory()->create(['sync_priority' => 10.0]);
        $user = User::factory()->create();

        UserAnimeList::factory()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
            'status' => WatchlistStatusEnum::COMPLETED,
        ]);

        $anime->refresh();
        $this->assertEquals(10.0, $anime->sync_priority);
    }

    public function test_episode_progress_update_does_not_increment(): void
    {
        $anime = Anime::factory()->create(['sync_priority' => 5.0]);
        $user = User::factory()->create();

        $entry = UserAnimeList::factory()->watching()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
        ]);

        // Priority was boosted on create
        $anime->refresh();
        $this->assertEquals(7.0, $anime->sync_priority);

        // Updating only episode_progress should NOT boost priority again
        $entry->update(['episode_progress' => 5]);

        $anime->refresh();
        $this->assertEquals(7.0, $anime->sync_priority);
    }

    public function test_plan_to_watch_increments_priority(): void
    {
        $anime = Anime::factory()->create(['sync_priority' => 5.0]);
        $user = User::factory()->create();

        UserAnimeList::factory()->planToWatch()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
        ]);

        $anime->refresh();
        $this->assertEquals(7.0, $anime->sync_priority);
    }

    public function test_status_change_to_watching_increments(): void
    {
        $anime = Anime::factory()->create(['sync_priority' => 5.0]);
        $user = User::factory()->create();

        $entry = UserAnimeList::factory()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
            'status' => WatchlistStatusEnum::COMPLETED,
        ]);

        // Priority should not have changed (completed)
        $anime->refresh();
        $this->assertEquals(5.0, $anime->sync_priority);

        // Update to watching
        $entry->update(['status' => WatchlistStatusEnum::WATCHING]);

        $anime->refresh();
        $this->assertEquals(7.0, $anime->sync_priority);
    }

    public function test_watching_status_increments_priority(): void
    {
        $anime = Anime::factory()->create(['sync_priority' => 5.0]);
        $user = User::factory()->create();

        UserAnimeList::factory()->watching()->create([
            'user_id' => $user->id,
            'anime_id' => $anime->id,
        ]);

        $anime->refresh();
        $this->assertEquals(7.0, $anime->sync_priority);
    }
}
