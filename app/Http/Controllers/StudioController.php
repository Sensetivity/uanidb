<?php

namespace App\Http\Controllers;

use App\Services\Frontend\StudioService;
use Illuminate\View\View;

class StudioController extends Controller
{
    public function __construct(
        private readonly StudioService $studioService,
    ) {}

    public function show(string $slug): View
    {
        $studio = $this->studioService->findBySlug($slug);

        return view('main.pages.studios.show', compact('studio'));
    }
}
