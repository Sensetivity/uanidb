<?php

namespace App\Http\Controllers;

use App\Enums\SeasonOfYearEnum;
use App\Models\Season;
use App\Services\Frontend\AnimeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeasonsController extends Controller
{
    public function __construct(
        private readonly AnimeService $animeService,
    ) {}

    public function index(Request $request): View
    {
        $year = $request->query('year');
        $seasonSlug = $request->query('season');
        $typeFilter = $request->query('type');

        if ($year && $seasonSlug) {
            $seasonEnum = SeasonOfYearEnum::fromString($seasonSlug);
            $season = $seasonEnum
                ? Season::query()->where('year', $year)->where('season_of_year', $seasonEnum)->first()
                : null;
        } else {
            $season = Season::query()->where('is_current', true)->first();
        }

        if (! $season) {
            $season = Season::query()->orderByDesc('year')->orderByDesc('season_of_year')->first();
        }

        $allAnimes = $season ? $this->animeService->getForSeason($season) : collect();
        $animes = ($season && $typeFilter) ? $this->animeService->getForSeason($season, $typeFilter) : $allAnimes;
        $seasons = Season::query()->orderByDesc('year')->orderByDesc('season_of_year')->get();

        return view('main.pages.seasons', compact('season', 'animes', 'allAnimes', 'seasons', 'typeFilter'));
    }
}
