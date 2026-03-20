<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\MalEntryDto;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Models\Studio;
use App\Services\AnimeImport\Processors\CompanyProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_detaches_all_company_relations(): void
    {
        $anime = Anime::factory()->create();
        $studio = Studio::factory()->create();
        $producer = Studio::factory()->create();
        $licensor = Studio::factory()->create();

        $anime->studios()->attach($studio->id, ['role' => 'studio', 'is_main' => true, 'order' => 0]);
        $anime->producers()->attach($producer->id, ['role' => 'producer', 'order' => 0]);
        $anime->licensors()->attach($licensor->id, ['region' => 'global', 'order' => 0]);

        (new CompanyProcessor())->clear($anime);

        $this->assertCount(0, $anime->studios()->get());
        $this->assertCount(0, $anime->producers()->get());
        $this->assertCount(0, $anime->licensors()->get());
    }

    public function test_sync_attaches_licensors_with_region(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(
            licensors: [new MalEntryDto(malId: 301, name: 'Funimation')],
        );

        (new CompanyProcessor())->sync($anime, $dto);

        $licensors = $anime->licensors()->get();
        $this->assertCount(1, $licensors);
        $this->assertEquals('global', $licensors->first()->pivot->region);
    }

    public function test_sync_attaches_producers(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(
            producers: [new MalEntryDto(malId: 201, name: 'Aniplex')],
        );

        (new CompanyProcessor())->sync($anime, $dto);

        $producers = $anime->producers()->get();
        $this->assertCount(1, $producers);
        $this->assertEquals('producer', $producers->first()->pivot->role);
    }

    public function test_sync_attaches_studios_with_first_as_main(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(
            studios: [
                new MalEntryDto(malId: 101, name: 'Studio Ghibli'),
                new MalEntryDto(malId: 102, name: 'Bones'),
            ],
        );

        (new CompanyProcessor())->sync($anime, $dto);

        $studios = $anime->studios()->get();
        $this->assertCount(2, $studios);

        $main = $studios->firstWhere('mal_id', 101);
        $this->assertTrue((bool) $main->pivot->is_main);
        $this->assertEquals('studio', $main->pivot->role);

        $secondary = $studios->firstWhere('mal_id', 102);
        $this->assertFalse((bool) $secondary->pivot->is_main);
    }

    public function test_sync_creates_new_studio_if_not_exists(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(
            studios: [new MalEntryDto(malId: 999, name: 'New Studio')],
        );

        (new CompanyProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('studios', ['mal_id' => 999, 'name' => 'New Studio']);
    }

    public function test_sync_does_nothing_with_empty_companies(): void
    {
        $anime = Anime::factory()->create();

        (new CompanyProcessor())->sync($anime, $this->makeDto());

        $this->assertCount(0, $anime->studios()->get());
        $this->assertCount(0, $anime->producers()->get());
        $this->assertCount(0, $anime->licensors()->get());
    }

    public function test_sync_reuses_existing_studio_by_mal_id(): void
    {
        $anime = Anime::factory()->create();
        Studio::query()->create(['mal_id' => 888, 'name' => 'Existing Studio']);

        $dto = $this->makeDto(
            studios: [new MalEntryDto(malId: 888, name: 'Existing Studio')],
        );

        (new CompanyProcessor())->sync($anime, $dto);

        $this->assertEquals(1, Studio::query()->where('mal_id', 888)->count());
    }

    private function makeDto(array $studios = [], array $producers = [], array $licensors = []): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(
                malId: 1,
                title: 'Test',
                type: AnimeTypeEnum::TV,
                studios: $studios,
                producers: $producers,
                licensors: $licensors,
            ),
        );
    }
}
