<?php

namespace App\Http\Controllers;

use App\Services\Frontend\PersonService;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function __construct(
        private readonly PersonService $personService,
    ) {}

    public function show(string $slug): View
    {
        $person = $this->personService->findBySlug($slug);

        return view('main.pages.people.show', compact('person'));
    }
}
