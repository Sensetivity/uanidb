@extends('main.layouts.app')

@section('title', 'Сезонні аніме - УкрАніме')

@php $activeNav = 'seasons'; @endphp

@section('content')
  <!-- Season Header -->
  <div class="bg-gradient-to-r from-blue-500/10 via-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <span class="text-4xl">❄️</span>
            <h1 class="text-4xl font-bold">Зима 2025</h1>
          </div>
          <p class="text-gray-400">Січень - Березень 2025 | 68 нових аніме</p>
        </div>
        <div class="flex gap-3">
          <select class="py-2.5 px-4 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500">
            <option>Зима 2025</option>
            <option>Осінь 2024</option>
            <option>Літо 2024</option>
            <option>Весна 2024</option>
            <option>Зима 2024</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-3 mb-8">
      <button class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium">Усі (68)</button>
      <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors">ТБ (42)</button>
      <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors">Продовження (18)</button>
      <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors">Нові (24)</button>
      <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors">Фільми (8)</button>
    </div>

    <!-- Most Anticipated -->
    <section class="mb-12">
      <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <span class="text-amber-400">🔥</span> Найочікуваніші
      </h2>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="relative group">
          <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/50 rounded-2xl overflow-hidden hover:bg-slate-800 transition-colors">
            <div class="relative">
              <img src="https://placehold.co/400x200/1e293b/94a3b8?text=Solo+Leveling+S2" alt="Solo Leveling" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
              <div class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg flex items-center gap-1">
                <span>🔥</span> #1 Очікуване
              </div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-green-500/80 backdrop-blur-sm text-xs rounded">Продовження</span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors mb-2">Solo Leveling S2</h3>
              <p class="text-sm text-gray-500 mb-3">A-1 Pictures | ТБ | 12 еп.</p>
              <div class="flex items-center gap-4 text-sm text-gray-400">
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  4 січня
                </div>
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                  125,430
                </div>
              </div>
            </div>
          </a>
          <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
            <div class="relative">
              <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              </button>
              <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                <div class="border-t border-slate-700"></div>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="relative group">
          <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/50 rounded-2xl overflow-hidden hover:bg-slate-800 transition-colors">
            <div class="relative">
              <img src="https://placehold.co/400x200/1e293b/94a3b8?text=Demon+Slayer+S5" alt="Demon Slayer" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
              <div class="absolute top-3 left-3 px-3 py-1 bg-slate-700 text-white text-xs font-bold rounded-lg">#2</div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-green-500/80 backdrop-blur-sm text-xs rounded">Продовження</span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors mb-2">Клинок: Арка замку нескінченності</h3>
              <p class="text-sm text-gray-500 mb-3">ufotable | Фільм</p>
              <div class="flex items-center gap-4 text-sm text-gray-400">
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  Лютий
                </div>
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                  98,750
                </div>
              </div>
            </div>
          </a>
          <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
            <div class="relative">
              <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              </button>
              <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                <div class="border-t border-slate-700"></div>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="relative group">
          <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/50 rounded-2xl overflow-hidden hover:bg-slate-800 transition-colors">
            <div class="relative">
              <img src="https://placehold.co/400x200/1e293b/94a3b8?text=Sakamoto+Days" alt="Sakamoto Days" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
              <div class="absolute top-3 left-3 px-3 py-1 bg-slate-700 text-white text-xs font-bold rounded-lg">#3</div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-cyan-500/80 backdrop-blur-sm text-xs rounded">Новинка</span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors mb-2">Sakamoto Days</h3>
              <p class="text-sm text-gray-500 mb-3">TMS Entertainment | ТБ | 24 еп.</p>
              <div class="flex items-center gap-4 text-sm text-gray-400">
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  11 січня
                </div>
                <div class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                  76,320
                </div>
              </div>
            </div>
          </a>
          <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
            <div class="relative">
              <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              </button>
              <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                <div class="border-t border-slate-700"></div>
                <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Full Season List -->
    <section>
      <h2 class="text-2xl font-bold mb-6">Усі аніме сезону</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">Apothecary Diaries S2</h4>
                <p class="text-xs text-gray-500 mb-2">Toho Animation • Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Драма</span><span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Детектив</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+1" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-cyan-500/80 text-xs rounded">Новинка</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Apothecary Diaries S2</h3>
          <p class="text-xs text-gray-500">ТБ | 24 еп.</p>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">Re:Zero S3</h4>
                <p class="text-xs text-gray-500 mb-2">White Fox • Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Фентезі</span><span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Психологія</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+2" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-green-500/80 text-xs rounded">Продовження</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Re:Zero S3</h3>
          <p class="text-xs text-gray-500">ТБ | 24 еп.</p>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">Unnamed Memory S2</h4>
                <p class="text-xs text-gray-500 mb-2">ENGI • Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Фентезі</span><span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Романтика</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+3" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-cyan-500/80 text-xs rounded">Новинка</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Unnamed Memory S2</h3>
          <p class="text-xs text-gray-500">ТБ | 12 еп.</p>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">Dr. Stone S4</h4>
                <p class="text-xs text-gray-500 mb-2">TMS Entertainment • Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Пригоди</span><span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Наука</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+4" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-green-500/80 text-xs rounded">Продовження</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Dr. Stone S4</h3>
          <p class="text-xs text-gray-500">ТБ | 12 еп.</p>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">Zenshu</h4>
                <p class="text-xs text-gray-500 mb-2">MAPPA • Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Драма</span><span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Повсякденність</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+5" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-cyan-500/80 text-xs rounded">Новинка</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Zenshu</h3>
          <p class="text-xs text-gray-500">ТБ | ? еп.</p>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative mb-2">
            <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                <h4 class="font-semibold text-gray-200 text-sm mb-1">The Do-Over Damsel</h4>
                <p class="text-xs text-gray-500 mb-2">Зима 2025</p>
                <div class="flex flex-wrap gap-1"><span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Романтика</span><span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Фентезі</span></div>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-xl">
              <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Anime+6" alt="Anime" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-cyan-500/80 text-xs rounded">Новинка</div>
            </div>
            <div class="absolute bottom-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-7 h-7 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">The Do-Over Damsel</h3>
          <p class="text-xs text-gray-500">ТБ | 12 еп.</p>
        </a>
      </div>
    </section>
  </div>
@endsection

@section('footer')
  @include('main.components.footer-compact')
@endsection

@push('scripts')
<script>
  function toggleListMenu(event, btn) {
    event.stopPropagation();
    const menu = btn.nextElementSibling;
    const isOpen = !menu.classList.contains('hidden');
    document.querySelectorAll('.list-dropdown').forEach(m => m.classList.add('hidden'));
    if (!isOpen) menu.classList.remove('hidden');
    menu.classList.add('list-dropdown');
  }
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.list-menu-container')) {
      document.querySelectorAll('.list-dropdown').forEach(m => m.classList.add('hidden'));
    }
  });
</script>
@endpush
