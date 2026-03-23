<?php

namespace App\Http\Controllers;

use App\Enums\RankingCategoryEnum;
use App\Services\Frontend\AnimeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RankingsController extends Controller
{
    public function __construct(
        private readonly AnimeService $animeService,
    ) {}

    public function index(Request $request): View
    {
        $categorySlug = $request->query('category', 'top');
        $category = RankingCategoryEnum::tryFrom($categorySlug) ?? RankingCategoryEnum::Top;
        $animes = $this->animeService->getTopByCategory($category, 25);

        return view('main.pages.rankings', compact('animes', 'category'));
    }
}
