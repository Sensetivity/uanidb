<?php

namespace Tests\Feature;

use App\Models\Anime;
use App\Models\Episode;
use App\Services\Translation\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class TranslateCommandsTest extends TestCase
{
    use RefreshDatabase;

    public function test_translate_anime_not_found(): void
    {
        $mock = $this->mockTranslationService();
        $mock->shouldNotReceive('translateAnimeSynopsis');

        $this->artisan('translate:anime', ['animeId' => 999])
            ->assertFailed();
    }

    public function test_translate_anime_requires_flag_or_id(): void
    {
        $this->artisan('translate:anime')
            ->assertFailed();
    }

    public function test_translate_anime_single(): void
    {
        $anime = Anime::factory()->create([
            'synopsis' => 'A test synopsis.',
            'synopsis_uk' => null,
        ]);

        $mock = $this->mockTranslationService();
        $mock->shouldReceive('translateAnimeSynopsis')
            ->once()
            ->andReturnTrue();

        $this->artisan('translate:anime', ['animeId' => $anime->id])
            ->assertSuccessful();
    }

    public function test_translate_anime_untranslated(): void
    {
        Anime::factory()->create([
            'synopsis' => 'Untranslated synopsis.',
            'synopsis_uk' => null,
        ]);

        Anime::factory()->create([
            'synopsis' => 'Already translated.',
            'synopsis_uk' => 'Вже перекладено.',
        ]);

        $mock = $this->mockTranslationService();
        $mock->shouldReceive('translateAnimeSynopsis')
            ->once()
            ->andReturnTrue();

        $this->artisan('translate:anime', ['--untranslated' => true])
            ->assertSuccessful();
    }

    public function test_translate_episodes_anime_not_found(): void
    {
        $this->artisan('translate:episodes', ['animeId' => 999])
            ->assertFailed();
    }

    public function test_translate_episodes_for_specific_anime(): void
    {
        $anime = Anime::factory()->create();

        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Ep 1',
            'title_en' => 'Episode One',
            'title_uk' => null,
        ]);

        $mock = $this->mockTranslationService();
        $mock->shouldReceive('translateEpisode')
            ->once()
            ->andReturnTrue();

        $this->artisan('translate:episodes', ['animeId' => $anime->id])
            ->assertSuccessful();
    }

    public function test_translate_episodes_untranslated(): void
    {
        $anime = Anime::factory()->create();

        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'Ep 1',
            'title_en' => 'Episode One',
            'title_uk' => null,
        ]);

        Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 2,
            'title' => 'Ep 2',
            'title_en' => 'Episode Two',
            'title_uk' => 'Епізод два',
            'synopsis' => null,
        ]);

        $mock = $this->mockTranslationService();
        $mock->shouldReceive('translateEpisode')
            ->once()
            ->andReturnTrue();

        $this->artisan('translate:episodes', ['--untranslated' => true])
            ->assertSuccessful();
    }

    private function mockTranslationService(): TranslationService
    {
        $mock = Mockery::mock(TranslationService::class);
        $this->app->instance(TranslationService::class, $mock);

        return $mock;
    }
}
