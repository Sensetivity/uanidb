<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\PersonDto;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Models\Person;
use App\Services\AnimeImport\Processors\StaffProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StaffProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_detaches_people(): void
    {
        $anime = Anime::factory()->create();
        $person = Person::factory()->create();
        $anime->people()->attach($person->id, ['role' => 'Director']);

        (new StaffProcessor())->clear($anime);

        $this->assertCount(0, $anime->people()->get());
    }

    public function test_sync_creates_person_and_attaches_with_positions(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new PersonDto(
                malId: 4001,
                name: 'Hayao Miyazaki',
                imageUrl: 'https://example.com/miyazaki.jpg',
                positions: ['Director', 'Script'],
            ),
        ]);

        (new StaffProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('people', ['mal_id' => 4001, 'name' => 'Hayao Miyazaki']);

        $roles = DB::table('anime_person')
            ->where('anime_id', $anime->id)
            ->pluck('role')
            ->toArray();

        $this->assertContains('Director', $roles);
        $this->assertContains('Script', $roles);
    }

    public function test_sync_does_nothing_with_empty_staff(): void
    {
        $anime = Anime::factory()->create();

        (new StaffProcessor())->sync($anime, $this->makeDto([]));

        $this->assertEquals(0, DB::table('anime_person')->where('anime_id', $anime->id)->count());
    }

    public function test_sync_handles_person_with_multiple_positions(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new PersonDto(
                malId: 7001,
                name: 'Multi-role Staff',
                positions: ['Director', 'Script', 'Storyboard'],
            ),
        ]);

        (new StaffProcessor())->sync($anime, $dto);

        $count = DB::table('anime_person')
            ->where('anime_id', $anime->id)
            ->count();

        $this->assertEquals(3, $count);
    }

    public function test_sync_ignores_duplicate_position_entries(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new PersonDto(malId: 6001, name: 'Staff A', positions: ['Director']),
        ]);

        $processor = new StaffProcessor();
        $processor->sync($anime, $dto);
        $processor->sync($anime, $dto);

        $count = DB::table('anime_person')
            ->where('anime_id', $anime->id)
            ->where('role', 'Director')
            ->count();

        $this->assertEquals(1, $count);
    }

    public function test_sync_updates_existing_person(): void
    {
        $anime = Anime::factory()->create();
        Person::query()->create(['mal_id' => 5001, 'name' => 'Old Name']);

        $dto = $this->makeDto([
            new PersonDto(malId: 5001, name: 'Updated Name', positions: ['Producer']),
        ]);

        (new StaffProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('people', ['mal_id' => 5001, 'name' => 'Updated Name']);
        $this->assertEquals(1, Person::query()->where('mal_id', 5001)->count());
    }

    private function makeDto(array $staff): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(malId: 1, title: 'Test', type: AnimeTypeEnum::TV),
            staff: $staff,
        );
    }
}
