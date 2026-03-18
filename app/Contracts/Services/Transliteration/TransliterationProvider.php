<?php

namespace App\Contracts\Services\Transliteration;

use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;

interface TransliterationProvider
{
    /**
     * Get the transliteration system identifier.
     */
    public function system(): TransliterationSystemEnum;

    /**
     * Transliterate text from the given script to Ukrainian.
     */
    public function transliterate(string $text, ScriptTypeEnum $script): string;
}
