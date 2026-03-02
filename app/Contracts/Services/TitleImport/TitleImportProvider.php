<?php

namespace App\Contracts\Services\TitleImport;

use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\Dto\AnimeTitleImportDto;
use App\Services\TitleImport\Dto\EpisodeTitleImportDto;

interface TitleImportProvider
{
    /**
     * Get Ukrainian titles for an anime from this provider.
     *
     * @return AnimeTitleImportDto[]
     */
    public function getAnimeUkTitles(Anime $anime): array;

    /**
     * Get Ukrainian title for a specific episode from this provider.
     */
    public function getEpisodeUkTitle(Episode $episode): ?EpisodeTitleImportDto;
}
