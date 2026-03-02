<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\ExternalLinkDto;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Services\AnimeImport\Processors\ExternalLinkProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExternalLinkProcessorTest extends TestCase
{
    use RefreshDatabase;

    private function makeDto(array $externalLinks): AnimeFullDto
    {
        $anime = new AnimeDto(
            malId: 1,
            title: 'Test Anime',
            type: AnimeTypeEnum::TV,
            externalLinks: $externalLinks,
        );

        return new AnimeFullDto(anime: $anime);
    }

    public function test_sync_saves_external_links(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new ExternalLinkDto('AniDB', 'https://anidb.net/anime/7936'),
            new ExternalLinkDto('ANN', 'https://www.animenewsnetwork.com/encyclopedia/anime.php?id=6592'),
        ]);

        (new ExternalLinkProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('anime_external_links', [
            'anime_id' => $anime->id,
            'name'     => 'AniDB',
            'url'      => 'https://anidb.net/anime/7936',
        ]);

        $this->assertDatabaseHas('anime_external_links', [
            'anime_id' => $anime->id,
            'name'     => 'ANN',
        ]);

        $this->assertEquals(2, $anime->externalLinks()->count());
    }

    public function test_sync_extracts_anidb_id_from_modern_url(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => null]);

        $dto = $this->makeDto([
            new ExternalLinkDto('AniDB', 'https://anidb.net/anime/7936'),
        ]);

        (new ExternalLinkProcessor())->sync($anime, $dto);

        $this->assertEquals(7936, $anime->fresh()->anidb_id);
    }

    public function test_sync_extracts_anidb_id_from_legacy_url(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => null]);

        $dto = $this->makeDto([
            new ExternalLinkDto('AniDB', 'https://anidb.net/perl-bin/animedb.pl?show=anime&aid=4521'),
        ]);

        (new ExternalLinkProcessor())->sync($anime, $dto);

        $this->assertEquals(4521, $anime->fresh()->anidb_id);
    }

    public function test_sync_does_not_update_anidb_id_when_no_anidb_link(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 999]);

        $dto = $this->makeDto([
            new ExternalLinkDto('ANN', 'https://www.animenewsnetwork.com/encyclopedia/anime.php?id=6592'),
        ]);

        (new ExternalLinkProcessor())->sync($anime, $dto);

        $this->assertEquals(999, $anime->fresh()->anidb_id);
    }

    public function test_sync_does_nothing_when_external_links_empty(): void
    {
        $anime = Anime::factory()->create();

        (new ExternalLinkProcessor())->sync($anime, $this->makeDto([]));

        $this->assertEquals(0, $anime->externalLinks()->count());
    }

    public function test_clear_deletes_external_links(): void
    {
        $anime = Anime::factory()->create();
        $anime->externalLinks()->createMany([
            ['name' => 'AniDB', 'url' => 'https://anidb.net/anime/7936'],
            ['name' => 'ANN', 'url' => 'https://www.animenewsnetwork.com/encyclopedia/anime.php?id=6592'],
        ]);

        (new ExternalLinkProcessor())->clear($anime);

        $this->assertEquals(0, $anime->externalLinks()->count());
    }
}
