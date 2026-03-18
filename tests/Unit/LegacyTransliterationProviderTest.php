<?php

namespace Tests\Unit;

use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;
use App\Services\Transliteration\Legacy\LegacyTransliterationProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LegacyTransliterationProviderTest extends TestCase
{
    private LegacyTransliterationProvider $provider;

    #[Test]
    public function it_can_switch_between_scripts(): void
    {
        $romajiResult = $this->provider->transliterate('ka', ScriptTypeEnum::Romaji);
        $hiraganaResult = $this->provider->transliterate('か', ScriptTypeEnum::Hiragana);
        $katakanaResult = $this->provider->transliterate('カ', ScriptTypeEnum::Katakana);

        $this->assertNotEmpty($romajiResult);
        $this->assertNotEmpty($hiraganaResult);
        $this->assertNotEmpty($katakanaResult);
    }

    #[Test]
    public function it_handles_empty_string_hiragana(): void
    {
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Hiragana));
    }

    #[Test]
    public function it_handles_empty_string_katakana(): void
    {
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_handles_empty_string_romaji(): void
    {
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_digits(): void
    {
        $result = $this->provider->transliterate('123', ScriptTypeEnum::Romaji);

        $this->assertSame('123', $result);
    }

    #[Test]
    public function it_preserves_spaces(): void
    {
        $result = $this->provider->transliterate('a a', ScriptTypeEnum::Romaji);

        $this->assertStringContainsString(' ', $result);
    }

    #[Test]
    public function it_produces_consistent_results_on_repeated_calls(): void
    {
        $first = $this->provider->transliterate('tanaka', ScriptTypeEnum::Romaji);
        $second = $this->provider->transliterate('tanaka', ScriptTypeEnum::Romaji);

        $this->assertSame($first, $second);
    }

    #[Test]
    public function it_returns_legacy_system(): void
    {
        $this->assertSame(TransliterationSystemEnum::Legacy, $this->provider->system());
    }

    #[Test]
    public function it_transliterates_hiragana(): void
    {
        $result = $this->provider->transliterate('あいうえお', ScriptTypeEnum::Hiragana);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_transliterates_hiragana_compounds(): void
    {
        $result = $this->provider->transliterate('きゃ', ScriptTypeEnum::Hiragana);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_transliterates_katakana(): void
    {
        $result = $this->provider->transliterate('アイウエオ', ScriptTypeEnum::Katakana);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_transliterates_katakana_compounds(): void
    {
        $result = $this->provider->transliterate('キャ', ScriptTypeEnum::Katakana);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_transliterates_romaji(): void
    {
        $result = $this->provider->transliterate('tanaka', ScriptTypeEnum::Romaji);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function it_transliterates_romaji_multi_word(): void
    {
        $result = $this->provider->transliterate('tanaka taro', ScriptTypeEnum::Romaji);

        $this->assertIsString($result);
        $this->assertStringContainsString(' ', $result);
    }

    #[Test]
    public function it_transliterates_romaji_vowels(): void
    {
        $result = $this->provider->transliterate('a', ScriptTypeEnum::Romaji);

        $this->assertSame('а', $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new LegacyTransliterationProvider();
    }
}
