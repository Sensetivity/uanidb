<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\EpisodeDto;
use App\Enums\AnimeTypeEnum;
use App\Enums\EpisodeTypeEnum;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\AnimeImport\Processors\EpisodeProcessor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EpisodeProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_force_deletes_all_episodes(): void
    {
        $anime = Anime::factory()->create();
        Episode::factory()->count(3)->create(['anime_id' => $anime->id]);

        (new EpisodeProcessor())->clear($anime);

        $this->assertEquals(0, Episode::withTrashed()->where('anime_id', $anime->id)->count());
    }

    public function test_sync_creates_episodes(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new EpisodeDto(
                malId: 1,
                number: 1,
                title: 'Pilot',
                titleJa: 'パイロット',
                titleRo: 'Pairotto',
                aired: Carbon::parse('2024-01-15'),
                duration: 24,
            ),
            new EpisodeDto(malId: 2, number: 2, title: 'Episode 2'),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $this->assertEquals(2, $anime->episodes()->count());
        $this->assertDatabaseHas('episodes', [
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Pairotto',
            'title_en' => 'Pilot',
            'title_ja' => 'パイロット',
        ]);
    }

    public function test_sync_defaults_to_regular_type(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new EpisodeDto(malId: 1, number: 1, title: 'Normal Episode'),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $episode = $anime->episodes()->first();
        $this->assertEquals(EpisodeTypeEnum::Regular, $episode->type);
    }

    public function test_sync_does_nothing_with_empty_episodes(): void
    {
        $anime = Anime::factory()->create();

        (new EpisodeProcessor())->sync($anime, $this->makeDto([]));

        $this->assertEquals(0, $anime->episodes()->count());
    }

    public function test_sync_sets_filler_type(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new EpisodeDto(malId: 1, number: 1, title: 'Filler Episode', filler: true),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $episode = $anime->episodes()->first();
        $this->assertEquals(EpisodeTypeEnum::Filler, $episode->type);
    }

    public function test_sync_sets_recap_type(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new EpisodeDto(malId: 1, number: 1, title: 'Recap', recap: true),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $episode = $anime->episodes()->first();
        $this->assertEquals(EpisodeTypeEnum::Recap, $episode->type);
    }

    public function test_sync_updates_existing_episode_by_number(): void
    {
        $anime = Anime::factory()->create();
        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Old Title',
        ]);

        $dto = $this->makeDto([
            new EpisodeDto(malId: 1, number: 1, title: 'Updated Title'),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $this->assertEquals(1, $anime->episodes()->count());
        $this->assertDatabaseHas('episodes', ['anime_id' => $anime->id, 'title_en' => 'Updated Title']);
    }

    public function test_sync_uses_title_ro_over_title_when_available(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new EpisodeDto(malId: 1, number: 1, title: 'English Title', titleRo: 'Romaji Title'),
        ]);

        (new EpisodeProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('episodes', [
            'anime_id' => $anime->id,
            'title' => 'Romaji Title',
            'title_en' => 'English Title',
        ]);
    }

    private function makeDto(array $episodes): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(malId: 1, title: 'Test', type: AnimeTypeEnum::TV),
            episodes: $episodes,
        );
    }
}
