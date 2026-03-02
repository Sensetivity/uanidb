<?php

namespace App\Services\Translation;

readonly class TranslationUsage
{
    public function __construct(
        public int $characterCount,
        public int $characterLimit,
    ) {}
}
