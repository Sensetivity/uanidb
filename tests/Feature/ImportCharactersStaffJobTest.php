<?php

namespace Tests\Feature;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\CharacterDto;
use App\Dto\PersonDto;
use App\Dto\VoiceActorDto;
use App\Enums\CharacterRoleEnum;
use App\Jobs\ImportCharactersStaffJob;
use App\Models\Anime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ImportCharactersStaffJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_imports_characters_and_staff(): void
    {
        $anime = Anime::factory()->create(['mal_id' => 10]);

        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldReceive('getAnimeCharacters')
            ->once()
            ->with(10)
            ->andReturn([
                new CharacterDto(
                    malId: 1,
                    name: 'Test Character',
                    role: CharacterRoleEnum::Main,
                    voiceActors: [
                        new VoiceActorDto(malId: 11, name: 'VA Name'),
                    ],
                ),
            ]);

        $mockProvider->shouldReceive('getAnimeStaff')
            ->once()
            ->with(10)
            ->andReturn([
                new PersonDto(malId: 100, name: 'Director', positions: ['Director']),
            ]);

        $job = new ImportCharactersStaffJob($anime->id);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertEquals(1, $anime->characters()->count());
        $this->assertEquals(1, $anime->people()->count());
    }

    public function test_job_skips_when_anime_not_found(): void
    {
        $mockProvider = Mockery::mock(AnimeDataProvider::class);
        $this->app->instance(AnimeDataProvider::class, $mockProvider);

        $mockProvider->shouldNotReceive('getAnimeCharacters');
        $mockProvider->shouldNotReceive('getAnimeStaff');

        $job = new ImportCharactersStaffJob(999);
        $job->handle($this->app->make(\App\Services\AnimeImport\AnimeImportService::class));

        $this->assertTrue(true);
    }
}
