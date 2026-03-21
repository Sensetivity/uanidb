<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\Season;
use App\Models\User;
use App\Services\Frontend\HomeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $this->get(route('home'))
            ->assertOk();
    }

    public function test_home_page_works_with_empty_database(): void
    {
        $this->get(route('home'))
            ->assertOk();
    }

    public function test_home_service_limits_trending_results(): void
    {
        Anime::factory()->count(20)->create(['score' => 8.0]);

        $service = app(HomeService::class);
        $trending = $service->getTrendingAnime(5);

        $this->assertCount(5, $trending);
    }

    public function test_home_service_returns_current_season(): void
    {
        Season::factory()->create(['is_current' => false]);
        $current = Season::factory()->create(['is_current' => true, 'year' => 2026]);

        $service = app(HomeService::class);
        $season = $service->getCurrentSeason();

        $this->assertNotNull($season);
        $this->assertEquals(2026, $season->year);
    }

    public function test_home_service_returns_null_when_no_current_season(): void
    {
        $service = app(HomeService::class);
        $this->assertNull($service->getCurrentSeason());
    }

    public function test_home_service_returns_stats(): void
    {
        Anime::factory()->count(3)->create();
        Character::factory()->count(2)->create();
        Person::factory()->count(4)->create();
        User::factory()->count(1)->create();

        $service = app(HomeService::class);
        $stats = $service->getStats();

        $this->assertEquals(3, $stats['anime']);
        $this->assertEquals(2, $stats['characters']);
        $this->assertEquals(4, $stats['people']);
        $this->assertEquals(1, $stats['users']);
    }

    public function test_home_service_returns_trending_anime(): void
    {
        Anime::factory()->create(['score' => 9.0, 'title' => 'Top Anime']);
        Anime::factory()->create(['score' => null, 'title' => 'No Score']);

        $service = app(HomeService::class);
        $trending = $service->getTrendingAnime();

        $this->assertCount(1, $trending);
        $this->assertEquals('Top Anime', $trending->first()->title);
    }
}
