<?php

namespace App\Dto;

use App\Enums\AnimeTitleLanguageEnum;

readonly class AnimeTitleDto
{
    public function __construct(
        public AnimeTitleLanguageEnum $language,
        public string                 $title,
    ) {}
}
