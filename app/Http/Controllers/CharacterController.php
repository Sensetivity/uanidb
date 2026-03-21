<?php

namespace App\Http\Controllers;

use App\Services\Frontend\CharacterService;
use Illuminate\View\View;

class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterService $characterService,
    ) {}

    public function show(string $slug): View
    {
        $character = $this->characterService->findBySlug($slug);

        return view('main.pages.characters.show', compact('character'));
    }
}
