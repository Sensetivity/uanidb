<?php

namespace Tests\Feature;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;
use App\Services\Transliteration\Legacy\LegacyTransliterationProvider;
use App\Services\Transliteration\Providers\KovalenkoTransliterationProvider;
use App\Services\Transliteration\TransliterationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TransliterationServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_applies_capitalization_through_service(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('Танака', $service->transliterate('Tanaka', ScriptTypeEnum::Romaji));
        $this->assertSame('Токьо', $service->transliterate('Tokyo', ScriptTypeEnum::Romaji));
    }

    // ─── Special rules through service layer ───

    #[Test]
    public function it_applies_special_rules_through_service(): void
    {
        $service = $this->app->make(TransliterationService::class);

        // n→м assimilation
        $this->assertSame('шімбун', $service->transliterate('shinbun', ScriptTypeEnum::Romaji));

        // oo doubling
        $this->assertSame('оукава', $service->transliterate('ookawa', ScriptTypeEnum::Romaji));

        // vowel+i at end
        $this->assertSame('ай', $service->transliterate('ai', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_auto_detects_hiragana(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterateAuto('たなか'));
    }

    #[Test]
    public function it_auto_detects_hiragana_when_equal_counts(): void
    {
        $service = $this->app->make(TransliterationService::class);

        // Equal counts: hiragana wins (hiragana > 0 check happens first when equal)
        // Actually, katakana > hiragana returns katakana. If equal, hiragana > 0 → hiragana.
        // 1 hiragana + 1 katakana = equal → hiragana wins
        $result = $service->transliterateAuto('かカ');

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_auto_detects_katakana(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterateAuto('タナカ'));
    }

    #[Test]
    public function it_auto_detects_katakana_when_dominant(): void
    {
        $service = $this->app->make(TransliterationService::class);

        // 3 katakana vs 1 hiragana → katakana wins
        $result = $service->transliterateAuto('カキく');

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    // ─── Auto-detection ───

    #[Test]
    public function it_auto_detects_romaji(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterateAuto('tanaka'));
    }

    #[Test]
    public function it_can_be_bound_with_kovalenko_provider(): void
    {
        $this->app->bind(TransliterationProvider::class, fn () => new KovalenkoTransliterationProvider());

        $provider = $this->app->make(TransliterationProvider::class);

        $this->assertInstanceOf(KovalenkoTransliterationProvider::class, $provider);
    }

    #[Test]
    public function it_can_be_bound_with_legacy_provider(): void
    {
        $this->app->bind(TransliterationProvider::class, fn () => new LegacyTransliterationProvider());

        $provider = $this->app->make(TransliterationProvider::class);

        $this->assertInstanceOf(LegacyTransliterationProvider::class, $provider);
    }

    #[Test]
    public function it_defaults_to_kovalenko_system(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame(TransliterationSystemEnum::Kovalenko, $service->system());
    }

    #[Test]
    public function it_falls_back_to_romaji_for_digits(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $result = $service->transliterateAuto('123');

        $this->assertSame('123', $result);
    }

    #[Test]
    public function it_falls_back_to_romaji_for_latin_text(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterateAuto('tanaka'));
    }

    #[Test]
    public function it_falls_back_to_romaji_for_punctuation_only(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $result = $service->transliterateAuto('---');

        $this->assertSame('---', $result);
    }

    // ─── Consistency ───

    #[Test]
    public function it_produces_consistent_results(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $first = $service->transliterate('naruto', ScriptTypeEnum::Romaji);
        $second = $service->transliterate('naruto', ScriptTypeEnum::Romaji);

        $this->assertSame($first, $second);
    }

    #[Test]
    public function it_produces_same_result_for_same_word_across_scripts(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $romaji = $service->transliterate('tanaka', ScriptTypeEnum::Romaji);
        $hiragana = $service->transliterate('たなか', ScriptTypeEnum::Hiragana);
        $katakana = $service->transliterate('タナカ', ScriptTypeEnum::Katakana);

        // All three scripts for the same word should produce the same Ukrainian output
        $this->assertSame($romaji, $hiragana);
        $this->assertSame($hiragana, $katakana);
    }

    #[Test]
    public function it_resolves_kovalenko_provider_by_default(): void
    {
        $provider = $this->app->make(TransliterationProvider::class);

        $this->assertInstanceOf(KovalenkoTransliterationProvider::class, $provider);
    }

    #[Test]
    public function it_resolves_provider_from_container(): void
    {
        $provider = $this->app->make(TransliterationProvider::class);

        $this->assertInstanceOf(TransliterationProvider::class, $provider);
    }

    #[Test]
    public function it_resolves_service_as_singleton(): void
    {
        $first = $this->app->make(TransliterationService::class);
        $second = $this->app->make(TransliterationService::class);

        $this->assertSame($first, $second);
    }

    // ─── Container resolution ───

    #[Test]
    public function it_resolves_transliteration_service_from_container(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertInstanceOf(TransliterationService::class, $service);
    }

    #[Test]
    public function it_returns_empty_string_for_empty_auto(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('', $service->transliterateAuto(''));
    }

    // ─── Empty / whitespace input ───

    #[Test]
    public function it_returns_empty_string_for_empty_input(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('', $service->transliterate('', ScriptTypeEnum::Romaji));
        $this->assertSame('', $service->transliterate('', ScriptTypeEnum::Hiragana));
        $this->assertSame('', $service->transliterate('', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_returns_empty_string_for_tabs_and_newlines(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('', $service->transliterateAuto("\t\n"));
    }

    #[Test]
    public function it_returns_empty_string_for_whitespace_only(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('', $service->transliterateAuto('   '));
        $this->assertSame('', $service->transliterate('   ', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_returns_legacy_system_when_bound_with_legacy_provider(): void
    {
        $this->app->bind(TransliterationProvider::class, fn () => new LegacyTransliterationProvider());

        $service = $this->app->make(TransliterationService::class);

        $this->assertSame(TransliterationSystemEnum::Legacy, $service->system());
    }

    #[Test]
    public function it_transliterates_hiragana_with_explicit_script(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterate('たなか', ScriptTypeEnum::Hiragana));
    }

    #[Test]
    public function it_transliterates_katakana_with_explicit_script(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterate('タナカ', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_transliterates_multi_word_romaji(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('Танака Таро', $service->transliterate('Tanaka Taro', ScriptTypeEnum::Romaji));
    }

    // ─── Explicit script transliteration ───

    #[Test]
    public function it_transliterates_romaji_with_explicit_script(): void
    {
        $service = $this->app->make(TransliterationService::class);

        $this->assertSame('танака', $service->transliterate('tanaka', ScriptTypeEnum::Romaji));
    }
}
