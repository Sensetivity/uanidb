<?php

namespace App\Http\Controllers;

use App\Enums\StudioSortEnum;
use App\Services\Frontend\StudioService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudioController extends Controller
{
    public function __construct(
        private readonly StudioService $studioService,
    ) {}

    public function index(Request $request): View
    {
        $sort = StudioSortEnum::tryFrom($request->query('sort', '')) ?? StudioSortEnum::AnimeCount;
        $studios = $this->studioService->getList($sort, 50);

        return view('main.pages.studios.index', compact('studios', 'sort'));
    }

    public function show(string $slug): View
    {
        $studio = $this->studioService->findBySlug($slug);

        return view('main.pages.studios.show', compact('studio'));
    }
}
