<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/', fn () => view('main.pages.home'))->name('home');

// Anime
Route::get('/anime', fn () => view('main.pages.anime.index'))->name('anime.index');
Route::get('/anime/search', fn () => view('main.pages.anime.search'))->name('anime.search');
Route::get('/anime/calendar', fn () => view('main.pages.anime.calendar'))->name('anime.calendar');
Route::get('/anime/list-view', fn () => view('main.pages.anime.list-view'))->name('anime.list-view');
Route::get('/anime/{slug}', fn () => view('main.pages.anime.show'))->name('anime.show');

// Characters
Route::get('/characters', fn () => view('main.pages.characters.index'))->name('characters.index');
Route::get('/characters/{slug}', fn () => view('main.pages.characters.show'))->name('characters.show');

// People (voice actors)
Route::get('/people', fn () => view('main.pages.people.index'))->name('people.index');
Route::get('/people/{slug}', fn () => view('main.pages.people.show'))->name('people.show');

// Studios
Route::get('/studios', fn () => view('main.pages.studios.index'))->name('studios.index');
Route::get('/studios/{slug}', fn () => view('main.pages.studios.show'))->name('studios.show');

// Rankings & Seasons
Route::get('/rankings', fn () => view('main.pages.rankings'))->name('rankings');
Route::get('/seasons', fn () => view('main.pages.seasons'))->name('seasons');

// Profile
Route::get('/profile', fn () => view('main.pages.profile'))->name('profile');

// Auth
Route::get('/login', fn () => view('main.auth.login'))->name('login');
Route::get('/register', fn () => view('main.auth.register'))->name('register');
Route::get('/password/reset', fn () => view('main.auth.reset-password'))->name('password.reset');
