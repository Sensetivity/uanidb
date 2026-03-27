<?php

namespace Tests\Feature\Controllers;

use App\Models\Person;
use App\Services\Frontend\PersonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_paginates_results(): void
    {
        Person::factory()->count(35)->create();

        $response = $this->get(route('people.index'));
        $response->assertOk();

        $people = $response->viewData('people');
        $this->assertCount(30, $people->items());
        $this->assertEquals(35, $people->total());
    }

    public function test_index_returns_ok(): void
    {
        Person::factory()->count(3)->create();

        $this->get(route('people.index'))
            ->assertOk()
            ->assertViewHas('people');
    }

    public function test_index_returns_ok_with_empty_results(): void
    {
        $response = $this->get(route('people.index'));
        $response->assertOk();

        $this->assertEquals(0, $response->viewData('people')->total());
    }

    public function test_service_loads_person_with_relations(): void
    {
        $person = Person::factory()->create();

        $service = app(PersonService::class);
        $result = $service->findBySlug($person->slug);

        $this->assertTrue($result->relationLoaded('voicedCharacters'));
        $this->assertTrue($result->relationLoaded('animes'));
        $this->assertTrue($result->relationLoaded('media'));
    }

    public function test_service_paginates_list(): void
    {
        Person::factory()->count(5)->create();

        $service = app(PersonService::class);
        $results = $service->getList(perPage: 3);

        $this->assertEquals(5, $results->total());
        $this->assertCount(3, $results->items());
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get(route('people.show', 'nonexistent-slug'))
            ->assertNotFound();
    }

    public function test_show_returns_person_page(): void
    {
        $person = Person::factory()->create();

        $this->get(route('people.show', $person->slug))
            ->assertOk();
    }
}
