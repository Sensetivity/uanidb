<?php

namespace Tests\Feature;

use App\Contracts\Services\Translation\TranslationProvider;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\Translation\TranslationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(?TranslationProvider $provider = null): TranslationService
    {
        $provider ??= Mockery::mock(TranslationProvider::class);

        return new TranslationService($provider, 'UK');
    }

    public function test_translate_returns_translated_text(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translate')
            ->once()
            ->with('Hello world', 'UK')
            ->andReturn('Привіт світ');

        $result = $this->makeService($provider)->translate('Hello world');

        $this->assertEquals('Привіт світ', $result);
    }

    public function test_translate_returns_null_for_empty_text(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldNotReceive('translate');

        $service = $this->makeService($provider);

        $this->assertNull($service->translate(''));
        $this->assertNull($service->translate('   '));
    }

    public function test_translate_caches_result(): void
    {
        Cache::flush();

        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translate')
            ->once()
            ->with('Hello', 'UK')
            ->andReturn('Привіт');

        $service = $this->makeService($provider);

        $first = $service->translate('Hello');
        $second = $service->translate('Hello');

        $this->assertEquals('Привіт', $first);
        $this->assertEquals('Привіт', $second);
    }

    public function test_translate_batch_handles_mixed_texts(): void
    {
        Cache::flush();

        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translateBatch')
            ->once()
            ->with(['Hello', 'World'], 'UK')
            ->andReturn(['Привіт', 'Світ']);

        $results = $this->makeService($provider)->translateBatch(['Hello', '', 'World']);

        $this->assertEquals('Привіт', $results[0]);
        $this->assertNull($results[1]);
        $this->assertEquals('Світ', $results[2]);
    }

    public function test_translate_batch_uses_cache(): void
    {
        Cache::flush();

        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translateBatch')
            ->once()
            ->with(['Hello', 'World'], 'UK')
            ->andReturn(['Привіт', 'Світ']);

        // First call populates cache
        $this->makeService($provider)->translateBatch(['Hello', 'World']);

        // Second call: cache hit, no API call
        $provider2 = Mockery::mock(TranslationProvider::class);
        $provider2->shouldNotReceive('translateBatch');

        $results = $this->makeService($provider2)->translateBatch(['Hello', 'World']);

        $this->assertEquals('Привіт', $results[0]);
        $this->assertEquals('Світ', $results[1]);
    }

    public function test_translate_batch_returns_nulls_for_all_empty(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldNotReceive('translateBatch');

        $results = $this->makeService($provider)->translateBatch(['', '   ', '']);

        $this->assertNull($results[0]);
        $this->assertNull($results[1]);
        $this->assertNull($results[2]);
    }

    public function test_translate_anime_synopsis(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translate')
            ->once()
            ->with('A great anime about adventures.', 'UK')
            ->andReturn('Чудове аніме про пригоди.');

        $anime = Anime::factory()->create([
            'synopsis' => 'A great anime about adventures.',
            'synopsis_uk' => null,
        ]);

        $result = $this->makeService($provider)->translateAnimeSynopsis($anime);

        $this->assertTrue($result);
        $this->assertEquals('Чудове аніме про пригоди.', $anime->fresh()->synopsis_uk);
    }

    public function test_translate_anime_synopsis_skips_when_already_translated(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldNotReceive('translate');

        $anime = Anime::factory()->create([
            'synopsis' => 'A great anime.',
            'synopsis_uk' => 'Чудове аніме.',
        ]);

        $result = $this->makeService($provider)->translateAnimeSynopsis($anime);

        $this->assertFalse($result);
    }

    public function test_translate_anime_synopsis_skips_when_no_synopsis(): void
    {
        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldNotReceive('translate');

        $anime = Anime::factory()->create(['synopsis' => null]);

        $result = $this->makeService($provider)->translateAnimeSynopsis($anime);

        $this->assertFalse($result);
    }

    public function test_translate_episode_title_and_synopsis(): void
    {
        $anime = Anime::factory()->create();

        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'The Beginning',
            'title_en' => 'The Beginning',
            'title_uk' => null,
            'synopsis' => 'Our hero starts the journey.',
            'synopsis_uk' => null,
        ]);

        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldReceive('translate')
            ->with('The Beginning', 'UK')
            ->once()
            ->andReturn('Початок');
        $provider->shouldReceive('translate')
            ->with('Our hero starts the journey.', 'UK')
            ->once()
            ->andReturn('Наш герой починає подорож.');

        $result = $this->makeService($provider)->translateEpisode($episode);

        $this->assertTrue($result);
        $fresh = $episode->fresh();
        $this->assertEquals('Початок', $fresh->title_uk);
        $this->assertEquals('Наш герой починає подорож.', $fresh->synopsis_uk);
    }

    public function test_translate_episode_skips_already_translated(): void
    {
        $anime = Anime::factory()->create();

        $episode = Episode::factory()->create([
            'anime_id' => $anime->id,
            'number' => 1,
            'title' => 'The Beginning',
            'title_en' => 'The Beginning',
            'title_uk' => 'Початок',
            'synopsis' => 'Some synopsis',
            'synopsis_uk' => 'Якийсь синопсис',
        ]);

        $provider = Mockery::mock(TranslationProvider::class);
        $provider->shouldNotReceive('translate');

        $result = $this->makeService($provider)->translateEpisode($episode);

        $this->assertFalse($result);
    }
}
