<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\SeasonsController;
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
Route::get('/characters', [CharacterController::class, 'index'])->name('characters.index');
Route::get('/characters/{slug}', [CharacterController::class, 'show'])->name('characters.show');

// People (voice actors)
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/{slug}', [PersonController::class, 'show'])->name('people.show');

// Studios
Route::get('/studios', [StudioController::class, 'index'])->name('studios.index');
Route::get('/studios/{slug}', [StudioController::class, 'show'])->name('studios.show');

// Rankings & Seasons
Route::get('/rankings', [RankingsController::class, 'index'])->name('rankings');
Route::get('/seasons', [SeasonsController::class, 'index'])->name('seasons');

// Profile
Route::get('/profile', fn () => view('main.pages.profile'))->name('profile');

// Auth
Route::get('/login', fn () => view('main.auth.login'))->name('login');
Route::get('/register', fn () => view('main.auth.register'))->name('register');
Route::get('/password/reset', fn () => view('main.auth.reset-password'))->name('password.reset');
