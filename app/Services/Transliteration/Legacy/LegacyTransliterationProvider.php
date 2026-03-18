<?php

namespace App\Services\Transliteration\Legacy;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;
use App\Feature\Transliterator\TransliterationService as LegacyService;

class LegacyTransliterationProvider implements TransliterationProvider
{
    private LegacyService $legacy;

    public function __construct()
    {
        $this->legacy = new LegacyService();
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
