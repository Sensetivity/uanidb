<?php

namespace App\Http\Controllers;

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
        $typeFilter = $request->query('type');

        $season = ($request->query('year') && $request->query('season'))
            ? Season::findByYearAndSlug($request->query('year'), $request->query('season'))
            : null;

        $season ??= Season::findCurrentOrLatest();

        $allAnimes = $season ? $this->animeService->getForSeason($season) : collect();
        $typeCounts = $allAnimes->countBy(fn ($anime) => $anime->type?->value);
        $animes = $typeFilter ? $allAnimes->filter(fn ($anime) => $anime->type?->slug() === $typeFilter)->values() : $allAnimes;
        $seasons = Season::query()->orderByDesc('year')->orderByDesc('season_of_year')->get();

        return view('main.pages.seasons', compact('season', 'animes', 'allAnimes', 'typeCounts', 'seasons', 'typeFilter'));
    }
}
