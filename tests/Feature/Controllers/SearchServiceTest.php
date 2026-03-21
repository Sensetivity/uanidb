<?php

namespace Tests\Feature\Controllers;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\Studio;
use App\Services\Frontend\SearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_filters_by_category(): void
    {
        Anime::factory()->create(['title' => 'Test Anime']);
        Character::factory()->create(['name' => 'Test Character']);

        $service = app(SearchService::class);
        $results = $service->search('Test', 'anime');

        $this->assertCount(1, $results['anime']);
        $this->assertCount(0, $results['characters']);
    }

    public function test_search_finds_anime_by_title(): void
    {
        Anime::factory()->create(['title' => 'Frieren Journey']);
        Anime::factory()->create(['title' => 'Naruto']);

        $service = app(SearchService::class);
        $results = $service->search('Frieren');

        $this->assertCount(1, $results['anime']);
        $this->assertEquals('Frieren Journey', $results['anime']->first()->title);
    }

    public function test_search_finds_characters_by_name(): void
    {
        Character::factory()->create(['name' => 'Naruto Uzumaki']);

        $service = app(SearchService::class);
        $results = $service->search('Naruto');

        $this->assertCount(1, $results['characters']);
    }

    public function test_search_finds_people_by_name(): void
    {
        Person::factory()->create(['name' => 'Hayao Miyazaki']);

        $service = app(SearchService::class);
        $results = $service->search('Miyazaki');

        $this->assertCount(1, $results['people']);
    }

    public function test_search_finds_studios_by_name(): void
    {
        Studio::factory()->create(['name' => 'Studio Ghibli']);

        $service = app(SearchService::class);
        $results = $service->search('Ghibli');

        $this->assertCount(1, $results['studios']);
    }

    public function test_search_respects_limit(): void
    {
        Anime::factory()->count(10)->create(['title' => 'Test Anime']);

        $service = app(SearchService::class);
        $results = $service->search('Test', 'anime', 3);

        $this->assertCount(3, $results['anime']);
    }

    public function test_search_returns_empty_for_short_query(): void
    {
        Anime::factory()->create(['title' => 'A']);

        $service = app(SearchService::class);
        $results = $service->search('A');

        $this->assertCount(0, $results['anime']);
    }
}
