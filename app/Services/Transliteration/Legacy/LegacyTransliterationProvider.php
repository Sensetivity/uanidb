<?php

namespace App\Services\Transliteration\Legacy;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;

class LegacyTransliterationProvider implements TransliterationProvider
{
    private LegacyTransliterationService $legacy;

    public function __construct()
    {
        $this->legacy = new LegacyTransliterationService();
    }

    public function system(): TransliterationSystemEnum
    {
        return TransliterationSystemEnum::Legacy;
    }

    public function transliterate(string $text, ScriptTypeEnum $script): string
    {
        $mapKey = match ($script) {
            ScriptTypeEnum::Romaji => 'r2ua',
            ScriptTypeEnum::Hiragana => 'h2ua',
            ScriptTypeEnum::Katakana => 'k2ua',
        };

        $this->legacy->setMap($mapKey);

        return $this->legacy->transliterate($text);
    }
}
