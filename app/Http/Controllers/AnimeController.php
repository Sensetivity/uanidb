<?php

namespace App\Http\Controllers;

use App\Services\Frontend\AnimeService;
use Illuminate\View\View;

class AnimeController extends Controller
{
    public function __construct(
        private readonly AnimeService $animeService,
    ) {}

    public function show(string $slug): View
    {
        $anime = $this->animeService->findBySlug($slug);

        return view('main.pages.anime.show', compact('anime'));
    }
}
