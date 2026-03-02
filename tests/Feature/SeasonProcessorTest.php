<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Enums\AnimeTypeEnum;
use App\Enums\SeasonOfYearEnum;
use App\Models\Anime;
use App\Models\Season;
use App\Services\AnimeImport\Processors\SeasonProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonProcessorTest extends TestCase
{
    use RefreshDatabase;

    private SeasonProcessor $processor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->processor = new SeasonProcessor();
    }

    public function test_sync_attaches_existing_season(): void
    {
        $anime  = Anime::factory()->create();
        $season = Season::query()->create([
            'name'           => 'Winter 2024',
            'year'           => 2024,
            'season_of_year' => SeasonOfYearEnum::Winter,
            'is_current'     => false,
        ]);

        $this->processor->sync($anime, $this->makeFullDto($anime, season: 'winter', year: 2024));

        $this->assertCount(1, $anime->seasons);
        $this->assertEquals($season->id, $anime->seasons->first()->id);
    }

    public function test_sync_creates_season_when_missing(): void
    {
        $anime = Anime::factory()->create();

        $this->processor->sync($anime, $this->makeFullDto($anime, season: 'spring', year: 2023));

        $this->assertDatabaseHas('seasons', [
            'year'           => 2023,
            'season_of_year' => SeasonOfYearEnum::Spring->value,
            'name'           => 'Spring 2023',
        ]);
        $this->assertCount(1, $anime->fresh()->seasons);
    }

    public function test_sync_skips_when_no_season_data(): void
    {
        $anime = Anime::factory()->create();

        $this->processor->sync($anime, $this->makeFullDto($anime, season: null, year: null));

        $this->assertCount(0, $anime->seasons);
    }

    public function test_sync_skips_unknown_season_string(): void
    {
        $anime = Anime::factory()->create();

        $this->processor->sync($anime, $this->makeFullDto($anime, season: 'monsoon', year: 2024));

        $this->assertCount(0, $anime->seasons);
    }

    public function test_clear_detaches_all_seasons(): void
    {
        $anime  = Anime::factory()->create();
        $season = Season::query()->create([
            'name'           => 'Fall 2022',
            'year'           => 2022,
            'season_of_year' => SeasonOfYearEnum::Fall,
            'is_current'     => false,
        ]);
        $anime->seasons()->attach($season->id);

        $this->processor->clear($anime);

        $this->assertCount(0, $anime->fresh()->seasons);
    }

    public function test_anime_dto_carries_season_and_year(): void
    {
        $dto = AnimeDto::fromArray([
            'mal_id' => 1,
            'title'  => 'Test',
            'type'   => 'TV',
            'season' => 'fall',
            'year'   => 2024,
        ]);

        $this->assertSame('fall', $dto->season);
        $this->assertSame(2024, $dto->year);
    }

    private function makeFullDto(Anime $anime, ?string $season, ?int $year): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(
                malId: $anime->mal_id,
                title: $anime->title,
                type: AnimeTypeEnum::TV,
                season: $season,
                year: $year,
            ),
        );
    }
}
