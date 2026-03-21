<?php

namespace App\Http\Controllers;

use App\Services\Frontend\HomeService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeService $homeService,
    ) {}

    public function index(): View
    {
        return view('main.pages.home', [
            'trendingAnime' => $this->homeService->getTrendingAnime(),
            'stats' => $this->homeService->getStats(),
            'currentSeason' => $this->homeService->getCurrentSeason(),
        ]);
    }
}
