<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\AnimeTitleDto;
use App\Enums\AnimeTitleLanguageEnum;
use App\Enums\AnimeTitleTypeEnum;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Services\AnimeImport\Processors\TitleProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TitleProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_deletes_all_anime_titles(): void
    {
        $anime = Anime::factory()->create();
        $anime->titles()->createMany([
            ['title' => 'Title 1', 'language' => 'en', 'source' => AnimeTitleTypeEnum::Jikan],
            ['title' => 'Title 2', 'language' => 'ja', 'source' => AnimeTitleTypeEnum::Jikan],
        ]);

        (new TitleProcessor())->clear($anime);

        $this->assertEquals(0, $anime->titles()->count());
    }

    public function test_romaji_type_is_excluded_at_dto_parsing_level(): void
    {
        $dto = AnimeDto::fromArray([
            'mal_id' => 1,
            'title'  => 'Attack on Titan',
            'type'   => 'TV',
            'titles' => [
                ['type' => 'Default', 'title' => 'Attack on Titan'],
                ['type' => 'Romaji', 'title' => 'Shingeki no Kyojin'],
                ['type' => 'English', 'title' => 'Attack on Titan'],
                ['type' => 'Japanese', 'title' => '進撃の巨人'],
            ],
        ]);

        $languageValues = array_map(fn ($t) => $t->language->value, $dto->titles);

        $this->assertNotContains('Romaji', $languageValues);
        $this->assertCount(2, $dto->titles);
    }

    /**
     * Romaji ('Default') types from Jikan are excluded by AnimeTitleLanguageEnum::fromString()
     * returning null — they never reach TitleProcessor.
     * This test verifies that an empty titles array produces no DB records.
     */
    public function test_sync_does_nothing_when_titles_empty(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([]);

        (new TitleProcessor())->sync($anime, $dto);

        $this->assertEquals(0, $anime->titles()->count());
    }

    public function test_sync_saves_non_romaji_titles(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new AnimeTitleDto(AnimeTitleLanguageEnum::English, 'Attack on Titan'),
            new AnimeTitleDto(AnimeTitleLanguageEnum::Japanese, '進撃の巨人'),
        ]);

        (new TitleProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => 'Attack on Titan',
            'language' => 'en',
        ]);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => '進撃の巨人',
            'language' => 'ja',
        ]);

        $this->assertEquals(2, $anime->titles()->count());
    }

    private function makeDto(array $titles): AnimeFullDto
    {
        $anime = new AnimeDto(
            malId: 1,
            title: 'Romaji Title',
            type: AnimeTypeEnum::TV,
            titles: $titles,
        );

        return new AnimeFullDto(anime: $anime);
    }
}
