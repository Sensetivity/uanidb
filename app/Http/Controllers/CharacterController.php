<?php

namespace App\Http\Controllers;

use App\Enums\CharacterSortEnum;
use App\Services\Frontend\CharacterService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterService $characterService,
    ) {}

    public function index(Request $request): View
    {
        $sort = CharacterSortEnum::tryFrom($request->query('sort', '')) ?? CharacterSortEnum::Name;
        $characters = $this->characterService->getList($sort, 30);

        return view('main.pages.characters.index', compact('characters', 'sort'));
    }

    public function show(string $slug): View
    {
        $character = $this->characterService->findBySlug($slug);

        return view('main.pages.characters.show', compact('character'));
    }
}
