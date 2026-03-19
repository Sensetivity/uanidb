<?php

namespace Tests\Feature\Services;

use App\Enums\AnimeStatusEnum;
use App\Models\Anime;
use App\Services\Sync\SyncPriorityCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncPriorityCalculatorTest extends TestCase
{
    use RefreshDatabase;

    private SyncPriorityCalculator $calculator;

    public function test_airing_anime_gets_urgency_bonus(): void
    {
        $anime = Anime::factory()->airing()->recentlySynced()->create(['synopsis' => 'test']);

        // Load counts as the calculator expects
        $anime->loadCount(['episodes', 'characters']);

        $priority = $this->calculator->calculate($anime, 0, true);

        // Should include 50 for airing
        $this->assertGreaterThanOrEqual(50, $priority);
    }

    public function test_combined_scoring(): void
    {
        $anime = Anime::factory()->airing()->neverSynced()->create();
        $anime->loadCount(['episodes', 'characters']);

        // Airing(50) + staleness(40) + demand(10) + episodes(10) + characters(10) + no media(10) + no synopsis(10)
        $priority = $this->calculator->calculate($anime, 5, false);

        $this->assertGreaterThanOrEqual(130, $priority);
    }

    public function test_failure_penalty_caps_at_minus_30(): void
    {
        $anime = Anime::factory()->failedSync(5)->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $priorityWith3 = $this->calculator->calculate(
            Anime::factory()->failedSync(3)->create(['status' => AnimeStatusEnum::FINISHED, 'synopsis' => 'test'])->loadCount(['episodes', 'characters']),
            0,
            true,
        );

        $priorityWith5 = $this->calculator->calculate($anime, 0, true);

        // Both 3*10=30 and 5*10=50 should cap at -30
        $this->assertEquals($priorityWith3, $priorityWith5);
    }

    public function test_finished_anime_with_no_urgency(): void
    {
        $anime = Anime::factory()->recentlySynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'A complete synopsis',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $priority = $this->calculator->calculate($anime, 0, true);

        // No airing bonus, minimal staleness (recently synced = ~0 days)
        $this->assertLessThan(50, $priority);
    }

    public function test_never_synced_gets_max_staleness(): void
    {
        $anime = Anime::factory()->neverSynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $priority = $this->calculator->calculate($anime, 0, true);

        // Should include 40 for staleness (never synced)
        $this->assertGreaterThanOrEqual(40, $priority);
    }

    public function test_not_yet_aired_gets_boost(): void
    {
        $anime = Anime::factory()->recentlySynced()->create([
            'status' => AnimeStatusEnum::NOT_YET_AIRED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $priority = $this->calculator->calculate($anime, 0, true);

        // Should include 15 for not_yet_aired
        $this->assertGreaterThanOrEqual(15, $priority);
    }

    public function test_priority_never_goes_below_zero(): void
    {
        $anime = Anime::factory()->failedSync(3)->recentlySynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $priority = $this->calculator->calculate($anime, 0, true);

        $this->assertGreaterThanOrEqual(0, $priority);
    }

    public function test_user_demand_caps_at_30(): void
    {
        $anime = Anime::factory()->recentlySynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $with15 = $this->calculator->calculate($anime, 15, true);
        $with100 = $this->calculator->calculate($anime, 100, true);

        // Both should cap user demand at 30
        $this->assertEquals($with15, $with100);
    }

    public function test_user_demand_increases_priority(): void
    {
        $anime = Anime::factory()->recentlySynced()->create([
            'status' => AnimeStatusEnum::FINISHED,
            'synopsis' => 'test',
        ]);
        $anime->loadCount(['episodes', 'characters']);

        $withoutDemand = $this->calculator->calculate($anime, 0, true);
        $withDemand = $this->calculator->calculate($anime, 10, true);

        $this->assertGreaterThan($withoutDemand, $withDemand);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new SyncPriorityCalculator();
    }
}
