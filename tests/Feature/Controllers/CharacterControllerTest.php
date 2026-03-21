<?php

namespace Tests\Feature\Controllers;

use App\Models\Character;
use App\Services\Frontend\CharacterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_loads_character_with_relations(): void
    {
        $character = Character::factory()->create();

        $service = app(CharacterService::class);
        $result = $service->findBySlug($character->slug);

        $this->assertTrue($result->relationLoaded('animes'));
        $this->assertTrue($result->relationLoaded('voiceActors'));
        $this->assertTrue($result->relationLoaded('media'));
    }

    public function test_service_paginates_list(): void
    {
        Character::factory()->count(5)->create();

        $service = app(CharacterService::class);
        $results = $service->getList('name', 3);

        $this->assertEquals(5, $results->total());
        $this->assertCount(3, $results->items());
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get(route('characters.show', 'nonexistent-slug'))
            ->assertNotFound();
    }

    public function test_show_returns_character_page(): void
    {
        $character = Character::factory()->create();

        $this->get(route('characters.show', $character->slug))
            ->assertOk();
    }
}
