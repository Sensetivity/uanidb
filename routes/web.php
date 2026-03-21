<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Anime
Route::get('/anime', fn () => view('main.pages.anime.index'))->name('anime.index');
Route::get('/anime/search', fn () => view('main.pages.anime.search'))->name('anime.search');
Route::get('/anime/calendar', fn () => view('main.pages.anime.calendar'))->name('anime.calendar');
Route::get('/anime/{slug}', [AnimeController::class, 'show'])->name('anime.show');

// Characters
Route::get('/characters', fn () => view('main.pages.characters.index'))->name('characters.index');
Route::get('/characters/{slug}', [CharacterController::class, 'show'])->name('characters.show');

// People (voice actors)
Route::get('/people', fn () => view('main.pages.people.index'))->name('people.index');
Route::get('/people/{slug}', [PersonController::class, 'show'])->name('people.show');

// Studios
Route::get('/studios', fn () => view('main.pages.studios.index'))->name('studios.index');
Route::get('/studios/{slug}', [StudioController::class, 'show'])->name('studios.show');

// Rankings & Seasons
Route::get('/rankings', fn () => view('main.pages.rankings'))->name('rankings');
Route::get('/seasons', fn () => view('main.pages.seasons'))->name('seasons');

// Profile
Route::get('/profile', fn () => view('main.pages.profile'))->name('profile');

// Auth
Route::get('/login', fn () => view('main.auth.login'))->name('login');
Route::get('/register', fn () => view('main.auth.register'))->name('register');
Route::get('/password/reset', fn () => view('main.auth.reset-password'))->name('password.reset');
