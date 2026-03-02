<?php

namespace Tests\Feature;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\AnimeTitleDto;
use App\Dto\CharacterDto;
use App\Dto\EpisodeDto;
use App\Dto\MalEntryDto;
use App\Dto\PersonDto;
use App\Dto\PromotionVideoDto;
use App\Dto\VoiceActorDto;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTitleLanguageEnum;
use App\Enums\AnimeTitleTypeEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\CharacterRoleEnum;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AnimeImportTest extends TestCase
{
    use RefreshDatabase;

    private AnimeDataProvider $mockProvider;

    private AnimeImportService $importService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $this->mockProvider);

        $this->importService = $this->app->make(AnimeImportService::class);
    }

    public function test_import_creates_anime_with_all_relations(): void
    {
        $animeDto = new AnimeDto(
            malId: 1,
            title: 'Cowboy Bebop',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::FINISHED,
            titles: [
                new AnimeTitleDto(AnimeTitleLanguageEnum::English, 'Cowboy Bebop'),
                new AnimeTitleDto(AnimeTitleLanguageEnum::Japanese, 'カウボーイビバップ'),
            ],
            genres: [new MalEntryDto(1, 'Action')],
            studios: [new MalEntryDto(14, 'Sunrise')],
        );

        $this->mockProvider->shouldReceive('getAnime')
            ->once()
            ->with(1)
            ->andReturn($animeDto);

        $this->mockProvider->shouldReceive('getAnimeEpisodes')
            ->once()
            ->andReturn([
                new EpisodeDto(malId: 1, number: 1, title: 'Asteroid Blues'),
            ]);

        $this->mockProvider->shouldReceive('getAnimeCharacters')
            ->once()
            ->andReturn([
                new CharacterDto(
                    malId: 1,
                    name: 'Spike Spiegel',
                    role: CharacterRoleEnum::MAIN,
                    voiceActors: [
                        new VoiceActorDto(malId: 11, name: 'Yamadera Kouichi'),
                    ],
                ),
            ]);

        $this->mockProvider->shouldReceive('getAnimeStaff')
            ->once()
            ->andReturn([
                new PersonDto(malId: 100, name: 'Watanabe Shinichiro', positions: ['Director']),
            ]);

        $this->mockProvider->shouldReceive('getAnimeVideos')
            ->once()
            ->andReturn([
                new PromotionVideoDto(title: 'PV 1', videoUrl: 'https://example.com/pv1'),
            ]);

        $anime = $this->importService->importAnimeByMalId(1);

        $this->assertNotNull($anime);
        $this->assertEquals('Cowboy Bebop', $anime->title);
        $this->assertEquals(1, $anime->mal_id);

        $this->assertEquals(2, $anime->titles()->count());
        $this->assertEquals(1, $anime->genres()->count());
        $this->assertEquals(1, $anime->studios()->count());
        $this->assertEquals(1, $anime->episodes()->count());
        $this->assertEquals(1, $anime->characters()->count());
        $this->assertEquals(1, $anime->people()->count());
        $this->assertEquals(1, $anime->promotionVideos()->count());

        $this->assertDatabaseHas('character_voice', [
            'anime_id' => $anime->id,
            'language' => 'Japanese',
        ]);
    }

    public function test_import_stores_titles_with_jikan_source(): void
    {
        $animeDto = new AnimeDto(
            malId: 2,
            title: 'Test Anime',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::FINISHED,
            titles: [
                new AnimeTitleDto(AnimeTitleLanguageEnum::Japanese, 'テストアニメ'),
                new AnimeTitleDto(AnimeTitleLanguageEnum::English, 'Test Anime EN'),
            ],
        );

        $this->mockProvider->shouldReceive('getAnime')->once()->with(2)->andReturn($animeDto);
        $this->mockProvider->shouldReceive('getAnimeEpisodes')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeCharacters')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeStaff')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeVideos')->once()->andReturn([]);

        $anime = $this->importService->importAnimeByMalId(2);

        $this->assertNotNull($anime);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => 'テストアニメ',
            'language' => 'ja',
            'source'   => AnimeTitleTypeEnum::Jikan->value,
        ]);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => 'Test Anime EN',
            'language' => 'en',
            'source'   => AnimeTitleTypeEnum::Jikan->value,
        ]);
    }

    public function test_import_skips_existing_without_force(): void
    {
        $existingAnime = Anime::factory()->create(['mal_id' => 1]);

        $this->mockProvider->shouldNotReceive('getAnime');

        $anime = $this->importService->importAnimeByMalId(1, false);

        $this->assertEquals($existingAnime->id, $anime->id);
    }

    public function test_import_updates_existing_with_force(): void
    {
        $existingAnime = Anime::factory()->create([
            'mal_id' => 1,
            'title' => 'Old Title',
        ]);

        $animeDto = new AnimeDto(
            malId: 1,
            title: 'New Title',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::FINISHED,
        );

        $this->mockProvider->shouldReceive('getAnime')
            ->once()
            ->with(1)
            ->andReturn($animeDto);

        $this->mockProvider->shouldReceive('getAnimeEpisodes')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeCharacters')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeStaff')->once()->andReturn([]);
        $this->mockProvider->shouldReceive('getAnimeVideos')->once()->andReturn([]);

        $anime = $this->importService->importAnimeByMalId(1, true);

        $this->assertEquals($existingAnime->id, $anime->id);
        $this->assertEquals('New Title', $anime->fresh()->title);
    }

    public function test_import_returns_null_when_not_found_on_api(): void
    {
        $this->mockProvider->shouldReceive('getAnime')
            ->once()
            ->with(999999)
            ->andReturnNull();

        $result = $this->importService->importAnimeByMalId(999999);

        $this->assertNull($result);
    }

    public function test_import_base_anime_does_not_fetch_details(): void
    {
        $animeDto = new AnimeDto(
            malId: 50,
            title: 'Base Only Anime',
            type: AnimeTypeEnum::TV,
            status: AnimeStatusEnum::AIRING,
        );

        $this->mockProvider->shouldReceive('getAnime')
            ->once()
            ->with(50)
            ->andReturn($animeDto);

        $this->mockProvider->shouldNotReceive('getAnimeEpisodes');
        $this->mockProvider->shouldNotReceive('getAnimeCharacters');
        $this->mockProvider->shouldNotReceive('getAnimeStaff');
        $this->mockProvider->shouldNotReceive('getAnimeVideos');

        $anime = $this->importService->importBaseAnimeByMalId(50);

        $this->assertNotNull($anime);
        $this->assertEquals('Base Only Anime', $anime->title);
        $this->assertEquals(50, $anime->mal_id);
    }

    public function test_import_episodes_for_existing_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $this->mockProvider->shouldReceive('getAnimeEpisodes')
            ->once()
            ->with(10)
            ->andReturn([
                new EpisodeDto(malId: 1, number: 1, title: 'Episode 1'),
                new EpisodeDto(malId: 2, number: 2, title: 'Episode 2'),
            ]);

        $this->importService->importEpisodes($anime);

        $this->assertEquals(2, $anime->episodes()->count());
    }

    public function test_import_characters_and_staff_for_existing_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $this->mockProvider->shouldReceive('getAnimeCharacters')
            ->once()
            ->with(10)
            ->andReturn([
                new CharacterDto(
                    malId: 1,
                    name: 'Test Character',
                    role: CharacterRoleEnum::MAIN,
                    voiceActors: [
                        new VoiceActorDto(malId: 11, name: 'VA Name'),
                    ],
                ),
            ]);

        $this->mockProvider->shouldReceive('getAnimeStaff')
            ->once()
            ->with(10)
            ->andReturn([
                new PersonDto(malId: 100, name: 'Director', positions: ['Director']),
            ]);

        $this->importService->importCharactersAndStaff($anime);

        $this->assertEquals(1, $anime->characters()->count());
        $this->assertEquals(1, $anime->people()->count());
    }

    public function test_import_promotion_videos_for_existing_anime(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $this->mockProvider->shouldReceive('getAnimeVideos')
            ->once()
            ->with(10)
            ->andReturn([
                new PromotionVideoDto(title: 'PV 1', videoUrl: 'https://example.com/pv1'),
                new PromotionVideoDto(title: 'PV 2', videoUrl: 'https://example.com/pv2'),
            ]);

        $this->importService->importPromotionVideos($anime);

        $this->assertEquals(2, $anime->promotionVideos()->count());
    }

    public function test_import_episodes_clears_existing_before_sync(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $this->mockProvider->shouldReceive('getAnimeEpisodes')
            ->twice()
            ->with(10)
            ->andReturn([
                new EpisodeDto(malId: 1, number: 1, title: 'Episode 1'),
                new EpisodeDto(malId: 2, number: 2, title: 'Episode 2'),
            ]);

        $this->importService->importEpisodes($anime);
        $this->assertEquals(2, $anime->episodes()->count());

        $this->importService->importEpisodes($anime);
        $this->assertEquals(2, $anime->episodes()->count());
    }
}
