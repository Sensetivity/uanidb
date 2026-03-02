<?php

namespace App\Services\TitleImport\Dto;

use App\Enums\AnimeTitleTypeEnum;

class AnimeTitleImportDto
{
    public function __construct(
        public readonly string $title,
        public readonly AnimeTitleTypeEnum $source,
    ) {}
}
