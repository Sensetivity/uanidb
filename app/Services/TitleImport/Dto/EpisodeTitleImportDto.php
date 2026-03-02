<?php

namespace App\Services\TitleImport\Dto;

class EpisodeTitleImportDto
{
    public function __construct(
        public readonly string $titleUk,
    ) {}
}
