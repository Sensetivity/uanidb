<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\CharacterDto;
use App\Dto\VoiceActorDto;
use App\Enums\AnimeTypeEnum;
use App\Enums\CharacterRoleEnum;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Services\AnimeImport\Processors\CharacterProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CharacterProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_detaches_characters_and_deletes_voice_records(): void
    {
        $anime = Anime::factory()->create();
        $character = Character::factory()->create();
        $person = Person::factory()->create();

        $anime->characters()->attach($character->id, ['role' => CharacterRoleEnum::Main->value]);

        DB::table('character_voice')->insert([
            'character_id' => $character->id,
            'person_id' => $person->id,
            'anime_id' => $anime->id,
            'language' => 'Japanese',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (new CharacterProcessor())->clear($anime);

        $this->assertCount(0, $anime->characters);
        $this->assertDatabaseMissing('character_voice', ['anime_id' => $anime->id]);
    }

    public function test_sync_creates_characters_and_attaches_to_anime(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new CharacterDto(
                malId: 1001,
                name: 'Naruto Uzumaki',
                imageUrl: 'https://example.com/naruto.jpg',
                role: CharacterRoleEnum::Main,
            ),
            new CharacterDto(
                malId: 1002,
                name: 'Sasuke Uchiha',
                role: CharacterRoleEnum::Supporting,
            ),
        ]);

        (new CharacterProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('characters', ['mal_id' => 1001, 'name' => 'Naruto Uzumaki']);
        $this->assertDatabaseHas('characters', ['mal_id' => 1002, 'name' => 'Sasuke Uchiha']);
        $this->assertCount(2, $anime->characters()->get());

        $mainChar = $anime->characters()->where('mal_id', 1001)->first();
        $this->assertEquals(CharacterRoleEnum::Main->value, $mainChar->pivot->role);
    }

    public function test_sync_creates_voice_actors_for_characters(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new CharacterDto(
                malId: 2001,
                name: 'Test Character',
                role: CharacterRoleEnum::Main,
                voiceActors: [
                    new VoiceActorDto(malId: 3001, name: 'Junko Takeuchi', language: 'Japanese'),
                    new VoiceActorDto(malId: 3002, name: 'Maile Flanagan', language: 'English'),
                ],
            ),
        ]);

        (new CharacterProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('people', ['mal_id' => 3001, 'name' => 'Junko Takeuchi']);
        $this->assertDatabaseHas('people', ['mal_id' => 3002, 'name' => 'Maile Flanagan']);

        $voiceRecords = DB::table('character_voice')->where('anime_id', $anime->id)->get();
        $this->assertCount(2, $voiceRecords);
    }

    public function test_sync_does_nothing_with_empty_characters(): void
    {
        $anime = Anime::factory()->create();

        (new CharacterProcessor())->sync($anime, $this->makeDto([]));

        $this->assertCount(0, $anime->characters()->get());
    }

    public function test_sync_ignores_duplicate_voice_actor_entries(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new CharacterDto(
                malId: 6001,
                name: 'Char A',
                role: CharacterRoleEnum::Main,
                voiceActors: [
                    new VoiceActorDto(malId: 7001, name: 'VA One', language: 'Japanese'),
                ],
            ),
        ]);

        $processor = new CharacterProcessor();
        $processor->sync($anime, $dto);
        // Sync again — insertOrIgnore should prevent duplicates
        $processor->sync($anime, $dto);

        $voiceRecords = DB::table('character_voice')
            ->where('anime_id', $anime->id)
            ->where('person_id', Person::query()->where('mal_id', 7001)->first()->id)
            ->count();

        $this->assertEquals(1, $voiceRecords);
    }

    public function test_sync_updates_existing_character(): void
    {
        $anime = Anime::factory()->create();
        Character::query()->create(['mal_id' => 5001, 'name' => 'Old Name']);

        $dto = $this->makeDto([
            new CharacterDto(malId: 5001, name: 'Updated Name', role: CharacterRoleEnum::Main),
        ]);

        (new CharacterProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('characters', ['mal_id' => 5001, 'name' => 'Updated Name']);
        $this->assertEquals(1, Character::query()->where('mal_id', 5001)->count());
    }

    private function makeDto(array $characters): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(malId: 1, title: 'Test', type: AnimeTypeEnum::TV),
            characters: $characters,
        );
    }
}
