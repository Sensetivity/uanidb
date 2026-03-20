<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\RelatedAnimeEntryDto;
use App\Dto\RelatedAnimeGroupDto;
use App\Enums\AnimeRelationEnum;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\MalEntryTypeEnum;
use App\Models\Anime;
use App\Services\AnimeImport\Processors\RelatedAnimeProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatedAnimeProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_detaches_related_anime(): void
    {
        $anime = Anime::factory()->create();
        $related = Anime::factory()->create();
        $anime->relatedAnime()->attach($related->id, ['relation_type' => AnimeRelationEnum::SEQUEL->value]);

        (new RelatedAnimeProcessor())->clear($anime);

        $this->assertCount(0, $anime->relatedAnime()->get());
    }

    public function test_sync_creates_stub_anime_and_attaches_relation(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new RelatedAnimeGroupDto(
                relation: AnimeRelationEnum::SEQUEL,
                entries: [
                    new RelatedAnimeEntryDto(malId: 9001, type: MalEntryTypeEnum::Anime, name: 'Sequel Anime'),
                ],
            ),
        ]);

        (new RelatedAnimeProcessor())->sync($anime, $dto);

        $this->assertDatabaseHas('animes', [
            'mal_id' => 9001,
            'title' => 'Sequel Anime',
            'type' => AnimeTypeEnum::UNKNOWN->value,
            'status' => AnimeStatusEnum::NOT_YET_AIRED->value,
        ]);

        $related = $anime->relatedAnime()->get();
        $this->assertCount(1, $related);
        $this->assertEquals(AnimeRelationEnum::SEQUEL->value, $related->first()->pivot->relation_type);
    }

    public function test_sync_does_nothing_with_empty_relations(): void
    {
        $anime = Anime::factory()->create();

        (new RelatedAnimeProcessor())->sync($anime, $this->makeDto([]));

        $this->assertCount(0, $anime->relatedAnime()->get());
    }

    public function test_sync_handles_multiple_relation_groups(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new RelatedAnimeGroupDto(
                relation: AnimeRelationEnum::SEQUEL,
                entries: [
                    new RelatedAnimeEntryDto(malId: 8001, type: MalEntryTypeEnum::Anime, name: 'Sequel'),
                ],
            ),
            new RelatedAnimeGroupDto(
                relation: AnimeRelationEnum::SPIN_OFF,
                entries: [
                    new RelatedAnimeEntryDto(malId: 8002, type: MalEntryTypeEnum::Anime, name: 'Spin Off'),
                ],
            ),
        ]);

        (new RelatedAnimeProcessor())->sync($anime, $dto);

        $this->assertCount(2, $anime->relatedAnime()->get());
    }

    public function test_sync_reuses_existing_anime_by_mal_id(): void
    {
        $anime = Anime::factory()->create();
        $existing = Anime::factory()->create(['mal_id' => 7777, 'title' => 'Already Exists']);

        $dto = $this->makeDto([
            new RelatedAnimeGroupDto(
                relation: AnimeRelationEnum::PREQUEL,
                entries: [
                    new RelatedAnimeEntryDto(malId: 7777, type: MalEntryTypeEnum::Anime, name: 'Already Exists'),
                ],
            ),
        ]);

        (new RelatedAnimeProcessor())->sync($anime, $dto);

        $this->assertEquals(1, Anime::query()->where('mal_id', 7777)->count());
        $this->assertCount(1, $anime->relatedAnime()->get());
    }

    public function test_sync_skips_non_anime_entries(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto([
            new RelatedAnimeGroupDto(
                relation: AnimeRelationEnum::ADAPTATION,
                entries: [
                    new RelatedAnimeEntryDto(malId: 100, type: MalEntryTypeEnum::Manga, name: 'Some Manga'),
                ],
            ),
        ]);

        (new RelatedAnimeProcessor())->sync($anime, $dto);

        $this->assertCount(0, $anime->relatedAnime()->get());
    }

    private function makeDto(array $relatedAnime): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(
                malId: 1,
                title: 'Test',
                type: AnimeTypeEnum::TV,
                relatedAnime: $relatedAnime,
            ),
        );
    }
}
