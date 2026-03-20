<?php

namespace Tests\Feature;

use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Dto\MalEntryDto;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Theme;
use App\Services\AnimeImport\Processors\TaxonomyProcessor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxonomyProcessorTest extends TestCase
{
    use RefreshDatabase;

    public function test_clear_detaches_all_genres(): void
    {
        $anime = Anime::factory()->create();
        $genre = Genre::factory()->create();
        $anime->genres()->attach($genre->id);

        $processor = new TaxonomyProcessor('genres', Genre::class, 'genres');
        $processor->clear($anime);

        $this->assertCount(0, $anime->genres()->get());
    }

    public function test_sync_creates_and_attaches_genres(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(genres: [
            new MalEntryDto(malId: 1, name: 'Action'),
            new MalEntryDto(malId: 2, name: 'Adventure'),
        ]);

        $processor = new TaxonomyProcessor('genres', Genre::class, 'genres');
        $processor->sync($anime, $dto);

        $this->assertCount(2, $anime->genres()->get());
        $this->assertDatabaseHas('genres', ['mal_title' => 'Action']);
        $this->assertDatabaseHas('genres', ['mal_title' => 'Adventure']);
    }

    public function test_sync_does_nothing_with_empty_terms(): void
    {
        $anime = Anime::factory()->create();

        $processor = new TaxonomyProcessor('genres', Genre::class, 'genres');
        $processor->sync($anime, $this->makeDto());

        $this->assertCount(0, $anime->genres()->get());
    }

    public function test_sync_replaces_previous_genres(): void
    {
        $anime = Anime::factory()->create();
        $oldGenre = Genre::factory()->create();
        $anime->genres()->attach($oldGenre->id);

        $dto = $this->makeDto(genres: [new MalEntryDto(malId: 50, name: 'Comedy')]);

        $processor = new TaxonomyProcessor('genres', Genre::class, 'genres');
        $processor->sync($anime, $dto);

        $genres = $anime->genres()->get();
        $this->assertCount(1, $genres);
        $this->assertEquals('Comedy', $genres->first()->mal_title);
    }

    public function test_sync_reuses_existing_genre_by_mal_title(): void
    {
        $anime = Anime::factory()->create();
        Genre::query()->create(['mal_title' => 'Action', 'name' => 'Екшн']);

        $dto = $this->makeDto(genres: [new MalEntryDto(malId: 1, name: 'Action')]);

        $processor = new TaxonomyProcessor('genres', Genre::class, 'genres');
        $processor->sync($anime, $dto);

        $this->assertEquals(1, Genre::query()->where('mal_title', 'Action')->count());
        $this->assertCount(1, $anime->genres()->get());
    }

    public function test_sync_works_for_themes(): void
    {
        $anime = Anime::factory()->create();

        $dto = $this->makeDto(themes: [
            new MalEntryDto(malId: 10, name: 'School'),
            new MalEntryDto(malId: 11, name: 'Music'),
        ]);

        $processor = new TaxonomyProcessor('themes', Theme::class, 'themes');
        $processor->sync($anime, $dto);

        $this->assertCount(2, $anime->themes()->get());
        $this->assertDatabaseHas('themes', ['mal_title' => 'School']);
    }

    private function makeDto(array $genres = [], array $themes = []): AnimeFullDto
    {
        return new AnimeFullDto(
            anime: new AnimeDto(
                malId: 1,
                title: 'Test',
                type: AnimeTypeEnum::TV,
                genres: $genres,
                themes: $themes,
            ),
        );
    }
}
