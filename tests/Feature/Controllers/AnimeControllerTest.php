<?php

namespace Tests\Feature\Controllers;

use App\Dto\AnimeFilterDto;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\RankingCategoryEnum;
use App\Models\Anime;
use App\Models\Genre;
use App\Services\Frontend\AnimeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_dto_from_query_string(): void
    {
        $dto = AnimeFilterDto::fromQueryString([
            'type' => 'tv,movie',
            'status' => 'airing',
            'genre' => 'action,comedy',
            'year' => '2024',
            'score' => '8',
            'sort' => 'score',
            'q' => 'naruto',
        ]);

        $this->assertEquals('naruto', $dto->search);
        $this->assertCount(2, $dto->types);
        $this->assertContains(AnimeTypeEnum::TV, $dto->types);
        $this->assertContains(AnimeTypeEnum::MOVIE, $dto->types);
        $this->assertCount(1, $dto->statuses);
        $this->assertContains(AnimeStatusEnum::AIRING, $dto->statuses);
        $this->assertEquals(['action', 'comedy'], $dto->genres);
        $this->assertEquals(2024, $dto->yearFrom);
        $this->assertEquals(8.0, $dto->minScore);
        $this->assertEquals('score', $dto->sortBy);
    }

    public function test_filter_dto_ignores_invalid_slugs(): void
    {
        $dto = AnimeFilterDto::fromQueryString([
            'type' => 'tv,invalid,movie',
            'status' => 'nonsense',
        ]);

        $this->assertCount(2, $dto->types);
        $this->assertCount(0, $dto->statuses);
    }

    public function test_filter_dto_to_query_string(): void
    {
        $dto = new AnimeFilterDto(
            search: 'test',
            types: [AnimeTypeEnum::TV],
            statuses: [AnimeStatusEnum::AIRING],
            genres: ['action'],
            yearFrom: 2024,
        );

        $query = $dto->toQueryString();

        $this->assertEquals('test', $query['q']);
        $this->assertEquals('tv', $query['type']);
        $this->assertEquals('airing', $query['status']);
        $this->assertEquals('action', $query['genre']);
        $this->assertEquals('2024', $query['year_from']);
    }

    public function test_service_filters_by_genre_slug(): void
    {
        $genre = Genre::factory()->create(['mal_title' => 'Action']);
        $anime = Anime::factory()->create();
        $anime->genres()->attach($genre->id);
        Anime::factory()->create();

        $service = app(AnimeService::class);
        $results = $service->getByFilters(new AnimeFilterDto(genres: ['action']));

        $this->assertEquals(1, $results->total());
    }

    public function test_service_filters_by_min_score(): void
    {
        Anime::factory()->create(['score' => 5.0]);
        Anime::factory()->create(['score' => 9.0]);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(new AnimeFilterDto(minScore: 8.0));

        $this->assertEquals(1, $results->total());
    }

    public function test_service_filters_by_type(): void
    {
        Anime::factory()->create(['type' => AnimeTypeEnum::TV, 'score' => 8.0]);
        Anime::factory()->create(['type' => AnimeTypeEnum::MOVIE, 'score' => 9.0]);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(new AnimeFilterDto(types: [AnimeTypeEnum::TV]));

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
        Anime::factory()->create(['type' => AnimeTypeEnum::MOVIE, 'score' => 9.0]);
        Anime::factory()->create(['type' => AnimeTypeEnum::TV, 'score' => 8.0]);

        $service = app(AnimeService::class);
        $movies = $service->getTopByCategory(RankingCategoryEnum::Movies);

        $this->assertEquals(1, $movies->total());
    }

    public function test_service_searches_by_title(): void
    {
        Anime::factory()->create(['title' => 'Naruto Shippuden']);
        Anime::factory()->create(['title' => 'One Piece']);

        $service = app(AnimeService::class);
        $results = $service->getByFilters(new AnimeFilterDto(search: 'Naruto'));

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
