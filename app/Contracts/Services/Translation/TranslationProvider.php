<?php

namespace App\Contracts\Services\Translation;

interface TranslationProvider
{
    /**
     * Translate a single text string.
     */
    public function translate(string $text, string $targetLang): ?string;

    /**
     * Translate multiple texts in a single API call.
     *
     * @param  array<string>  $texts
     * @return array<string|null>
     */
    public function translateBatch(array $texts, string $targetLang): array;
}
