<?php

namespace Tests\Feature\Controllers;

use App\Models\Anime;
use App\Services\Frontend\AnimeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_filters_by_min_score(): void
    {
        Anime::factory()->create(['score' => 5.0]);
        Anime::factory()->create(['score' => 9.0]);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(['minScore' => 8.0]);

        $this->assertEquals(1, $results->total());
    }

    public function test_service_filters_by_type(): void
    {
        Anime::factory()->create(['type' => \App\Enums\AnimeTypeEnum::TV, 'score' => 8.0]);
        Anime::factory()->create(['type' => \App\Enums\AnimeTypeEnum::MOVIE, 'score' => 9.0]);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(['types' => [\App\Enums\AnimeTypeEnum::TV]]);

        $this->assertEquals(1, $results->total());
    }

    public function test_service_loads_anime_with_relations(): void
    {
        $anime = Anime::factory()->create();

        $service = app(AnimeService::class);
        $result = $service->findBySlug($anime->slug);

        $this->assertTrue($result->relationLoaded('genres'));
        $this->assertTrue($result->relationLoaded('themes'));
        $this->assertTrue($result->relationLoaded('studios'));
        $this->assertTrue($result->relationLoaded('media'));
    }

    public function test_service_returns_top_by_category(): void
    {
        Anime::factory()->create(['type' => \App\Enums\AnimeTypeEnum::MOVIE, 'score' => 9.0]);
        Anime::factory()->create(['type' => \App\Enums\AnimeTypeEnum::TV, 'score' => 8.0]);

        $service = app(AnimeService::class);
        $movies = $service->getTopByCategory('movies');

        $this->assertEquals(1, $movies->total());
    }

    public function test_service_searches_by_title(): void
    {
        Anime::factory()->create(['title' => 'Naruto Shippuden']);
        Anime::factory()->create(['title' => 'One Piece']);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(['search' => 'Naruto']);

        $this->assertEquals(1, $results->total());
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get(route('anime.show', 'nonexistent-slug'))
            ->assertNotFound();
    }

    public function test_show_returns_anime_page(): void
    {
        $anime = Anime::factory()->create();

        $this->get(route('anime.show', $anime->slug))
            ->assertOk();
    }
}
