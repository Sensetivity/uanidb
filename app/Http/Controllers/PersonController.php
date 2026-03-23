<?php

namespace App\Http\Controllers;

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
        $sortBy = $request->query('sort', 'name');
        $people = $this->personService->getList($sortBy, 30);

        return view('main.pages.people.index', compact('people', 'sortBy'));
    }

    public function show(string $slug): View
    {
        $person = $this->personService->findBySlug($slug);

        return view('main.pages.people.show', compact('person'));
    }
}
