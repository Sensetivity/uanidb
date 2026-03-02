<?php

namespace Tests\Feature;

use App\Contracts\Services\TitleImport\TitleImportProvider;
use App\Enums\AnimeTitleTypeEnum;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\Dto\AnimeTitleImportDto;
use App\Services\TitleImport\Dto\EpisodeTitleImportDto;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class TitleImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_anime_adds_new_title_with_force(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 5]);
        $anime->titles()->create([
            'title'    => 'Атака Титанів',
            'language' => 'uk',
            'source'   => AnimeTitleTypeEnum::Official,
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getAnimeUkTitles')
            ->once()
            ->andReturn([
                new AnimeTitleImportDto('Атака Титанів', AnimeTitleTypeEnum::Official),
                new AnimeTitleImportDto('Атака Гігантів', AnimeTitleTypeEnum::Syn),
            ]);

        $count = $this->makeService($provider)->importAnime($anime, force: true);

        // 'Атака Титанів' already exists so only 'Атака Гігантів' is created
        $this->assertEquals(1, $count);
        $this->assertEquals(2, $anime->titles()->where('language', 'uk')->count());
    }

    public function test_import_anime_creates_uk_titles(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 5]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getAnimeUkTitles')
            ->once()
            ->andReturn([
                new AnimeTitleImportDto('Атака Титанів', AnimeTitleTypeEnum::Official),
                new AnimeTitleImportDto('Атака Гігантів', AnimeTitleTypeEnum::Syn),
            ]);

        $count = $this->makeService($provider)->importAnime($anime);

        $this->assertEquals(2, $count);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => 'Атака Титанів',
            'language' => 'uk',
            'source'   => AnimeTitleTypeEnum::Official->value,
        ]);

        $this->assertDatabaseHas('anime_titles', [
            'anime_id' => $anime->id,
            'title'    => 'Атака Гігантів',
            'language' => 'uk',
            'source'   => AnimeTitleTypeEnum::Syn->value,
        ]);
    }

    public function test_import_anime_returns_zero_when_provider_has_no_titles(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getAnimeUkTitles')
            ->once()
            ->with($anime)
            ->andReturn([]);

        $count = $this->makeService($provider)->importAnime($anime);

        $this->assertEquals(0, $count);
        $this->assertEquals(0, $anime->titles()->where('language', 'uk')->count());
    }

    public function test_import_anime_skips_existing_titles_without_force(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 5]);
        $anime->titles()->create([
            'title'    => 'Атака Титанів',
            'language' => 'uk',
            'source'   => AnimeTitleTypeEnum::Official,
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getAnimeUkTitles')
            ->once()
            ->andReturn([
                new AnimeTitleImportDto('Атака Титанів', AnimeTitleTypeEnum::Official),
            ]);

        $count = $this->makeService($provider)->importAnime($anime, false);

        $this->assertEquals(0, $count);
        $this->assertEquals(1, $anime->titles()->where('language', 'uk')->count());
    }

    public function test_import_episode_imports_uk_title(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1]);
        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number'   => 1,
            'title_uk' => null,
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getEpisodeUkTitle')
            ->once()
            ->with($episode)
            ->andReturn(new EpisodeTitleImportDto('Астероїдний блюз'));

        $result = $this->makeService($provider)->importEpisode($episode);

        $this->assertTrue($result);
        $this->assertEquals('Астероїдний блюз', $episode->fresh()->title_uk);
    }

    public function test_import_episode_reimports_with_force(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1]);
        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number'   => 1,
            'title_uk' => 'Старий переклад',
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getEpisodeUkTitle')
            ->once()
            ->andReturn(new EpisodeTitleImportDto('Новий переклад'));

        $result = $this->makeService($provider)->importEpisode($episode, force: true);

        $this->assertTrue($result);
        $this->assertEquals('Новий переклад', $episode->fresh()->title_uk);
    }

    public function test_import_episode_returns_false_when_provider_returns_null(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1]);
        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number'   => 1,
            'title_uk' => null,
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldReceive('getEpisodeUkTitle')
            ->once()
            ->andReturnNull();

        $result = $this->makeService($provider)->importEpisode($episode);

        $this->assertFalse($result);
        $this->assertNull($episode->fresh()->title_uk);
    }

    public function test_import_episode_skips_when_title_uk_already_set(): void
    {
        $anime = Anime::factory()->create(['anidb_id' => 1]);
        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number'   => 1,
            'title_uk' => 'Вже є переклад',
        ]);

        $provider = Mockery::mock(TitleImportProvider::class);
        $provider->shouldNotReceive('getEpisodeUkTitle');

        $result = $this->makeService($provider)->importEpisode($episode, force: false);

        $this->assertFalse($result);
    }

    private function makeService(TitleImportProvider $provider): TitleImportService
    {
        return new TitleImportService($provider);
    }
}
