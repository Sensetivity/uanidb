<?php

namespace Tests\Feature\Controllers;

use App\Models\Studio;
use App\Services\Frontend\StudioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_loads_studio_with_relations(): void
    {
        $studio = Studio::factory()->create();

        $service = app(StudioService::class);
        $result = $service->findBySlug($studio->slug);

        $this->assertTrue($result->relationLoaded('animes'));
        $this->assertTrue($result->relationLoaded('media'));
    }

    public function test_service_paginates_list(): void
    {
        Studio::factory()->count(5)->create();

        $service = app(StudioService::class);
        $results = $service->getList('name', 3);

        $this->assertEquals(5, $results->total());
        $this->assertCount(3, $results->items());
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get(route('studios.show', 'nonexistent-slug'))
            ->assertNotFound();
    }

    public function test_show_returns_studio_page(): void
    {
        $studio = Studio::factory()->create();

        $this->get(route('studios.show', $studio->slug))
            ->assertOk();
    }
}
