<?php

namespace App\Http\Controllers;

use App\Enums\PersonSortEnum;
use App\Services\Frontend\PersonService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function __construct(
        private readonly PersonService $personService,
    ) {}

    public function index(Request $request): View
    {
        $sort = $request->enum('sort', PersonSortEnum::class) ?? PersonSortEnum::Name;
        $people = $this->personService->getList($sort, 30);

        return view('main.pages.people.index', compact('people', 'sort'));
    }

    public function show(string $slug): View
    {
        $person = $this->personService->findBySlug($slug);

        return view('main.pages.people.show', compact('person'));
    }
}
