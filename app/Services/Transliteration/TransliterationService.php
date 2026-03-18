<?php

namespace App\Services\Transliteration;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;

class TransliterationService
{
    public function __construct(
        private TransliterationProvider $provider,
    ) {}

    /**
     * Get the active transliteration system.
     */
    public function system(): TransliterationSystemEnum
    {
        return $this->provider->system();
    }

    /**
     * Transliterate text using the specified script type.
     */
    public function transliterate(string $text, ScriptTypeEnum $script): string
    {
        if (trim($text) === '') {
            return '';
        }

        return $this->provider->transliterate($text, $script);
    }

    /**
     * Auto-detect script type and transliterate.
     * Detects hiragana, katakana, or falls back to romaji.
     */
    public function transliterateAuto(string $text): string
    {
        if (trim($text) === '') {
            return '';
        }

        $script = $this->detectScript($text);

        return $this->provider->transliterate($text, $script);
    }

    /**
     * Detect the dominant script in the text using Unicode ranges.
     *
     * Hiragana: U+3040–U+309F
     * Katakana: U+30A0–U+30FF
     */
    private function detectScript(string $text): ScriptTypeEnum
    {
        $hiraganaCount = preg_match_all('/[\x{3040}-\x{309F}]/u', $text);
        $katakanaCount = preg_match_all('/[\x{30A0}-\x{30FF}]/u', $text);

        if ($katakanaCount > $hiraganaCount) {
            return ScriptTypeEnum::Katakana;
        }

        if ($hiraganaCount > 0) {
            return ScriptTypeEnum::Hiragana;
        }

        return ScriptTypeEnum::Romaji;
    }
}
