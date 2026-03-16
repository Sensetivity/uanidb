@extends('main.layouts.app')

@section('title', 'Рейтинги - УкрАніме')

@php $activeNav = 'rankings'; @endphp

@section('content')
  <!-- Page Header -->
  <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Рейтинги аніме</h1>
      <p class="text-gray-400">Найкращі аніме за оцінками спільноти</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- Category Tabs -->
    <div class="flex flex-wrap gap-3 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <button class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium">Топ аніме</button>
      <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors">Найпопулярніші</button>
      <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors">Топ фільмів</button>
      <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors">Топ OVA</button>
      <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors">Топ персонажів</button>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
      <!-- Main Ranking List -->
      <div class="lg:col-span-2">
        <div class="space-y-4">
          <!-- Rank 1 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Стальний алхімік: Братерство</h4>
                <p class="text-xs text-gray-500 mb-3">Bones • 2009</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-amber-400 font-bold">★ 9.7</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">64 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/20 rounded-2xl hover:bg-amber-500/15 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">1</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=FMA" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Стальний алхімік: Братерство</h3>
                <p class="text-sm text-gray-500">ТБ | 64 еп. | Bones</p>
                <div class="flex gap-2 mt-1">
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Екшн</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Пригоди</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Фентезі</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-amber-400">9.7</div>
                <div class="text-xs text-gray-500">1,245,000 оцінок</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 2 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Steins;Gate</h4>
                <p class="text-xs text-gray-500 mb-3">White Fox • 2011</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.6</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">24 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Наукова фантастика</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Трилер</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">2</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Steins" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Steins;Gate</h3>
                <p class="text-sm text-gray-500">ТБ | 24 еп. | White Fox</p>
                <div class="flex gap-2 mt-1">
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Наукова фантастика</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Трилер</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.6</div>
                <div class="text-xs text-gray-500">987,000 оцінок</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 3 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Gintama: Фінал</h4>
                <p class="text-xs text-gray-500 mb-3">Bandai Namco Pictures • 2021</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.5</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">12 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Комедія</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Екшн</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">3</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Gintama" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Gintama: Фінал</h3>
                <p class="text-sm text-gray-500">ТБ | 12 еп. | Bandai Namco</p>
                <div class="flex gap-2 mt-1">
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Комедія</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Екшн</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.5</div>
                <div class="text-xs text-gray-500">456,000 оцінок</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 4 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Frieren: Похоронний обряд</h4>
                <p class="text-xs text-gray-500 mb-3">Madhouse • Осінь 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.4</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">28 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">4</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Frieren" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
                <p class="text-sm text-gray-500">ТБ | 28 еп. | Madhouse</p>
                <div class="flex gap-2 mt-1">
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Пригоди</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Драма</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.4</div>
                <div class="text-xs text-gray-500">542,000 оцінок</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 5 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Атака Титанів: Фінальний сезон</h4>
                <p class="text-xs text-gray-500 mb-3">MAPPA • 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.4</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">16 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">5</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=AoT" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Атака Титанів: Фінальний сезон</h3>
                <p class="text-sm text-gray-500">ТБ | 16 еп. | MAPPA</p>
                <div class="flex gap-2 mt-1">
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Екшн</span>
                  <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">Драма</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.4</div>
                <div class="text-xs text-gray-500">1,120,000 оцінок</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 6 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Hunter x Hunter (2011)</h4>
                <p class="text-xs text-gray-500 mb-3">Madhouse • 2011</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.3</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">148 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">6</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=HxH" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Hunter x Hunter (2011)</h3>
                <p class="text-sm text-gray-500">ТБ | 148 еп. | Madhouse</p>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.3</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 7 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Kaguya-sama: Love is War S3</h4>
                <p class="text-xs text-gray-500 mb-3">A-1 Pictures • 2022</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.2</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">13 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Романтика</span>
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Комедія</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">7</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Kaguya" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Kaguya-sama: Love is War S3</h3>
                <p class="text-sm text-gray-500">ТБ | 13 еп. | A-1 Pictures</p>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.2</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
          <!-- Rank 8 -->
          <div class="relative group">
            <div class="absolute right-20 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Clannad: After Story</h4>
                <p class="text-xs text-gray-500 mb-3">Kyoto Animation • 2008</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.2</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">24 еп.</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Романтика</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 pr-14 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
              <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold text-gray-400">8</div>
              <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Clannad" alt="Anime" class="w-16 h-22 object-cover rounded-lg">
              <div class="flex-grow">
                <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Clannad: After Story</h3>
                <p class="text-sm text-gray-500">ТБ | 24 еп. | Kyoto Animation</p>
              </div>
              <div class="text-right">
                <div class="text-3xl font-bold text-cyan-400">9.2</div>
              </div>
            </a>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
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
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
          <nav class="flex items-center gap-2">
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-500 text-white font-medium">1</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300">2</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300">3</button>
            <span class="text-gray-500 px-2">...</span>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300">100</button>
          </nav>
        </div>
      </div>

      <!-- Sidebar -->
      <div>
        <!-- Quick Stats -->
        <div class="bg-slate-800/50 rounded-2xl p-5 mb-6">
          <h3 class="font-semibold mb-4">Швидка статистика</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-500">Всього оцінено</span>
              <span>21,500 аніме</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Середня оцінка</span>
              <span class="text-cyan-400">7.2</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Топ-100 середня</span>
              <span class="text-amber-400">9.1</span>
            </div>
          </div>
        </div>

        <!-- Top by Year -->
        <div class="bg-slate-800/50 rounded-2xl p-5 mb-6">
          <h3 class="font-semibold mb-4">Топ за роками</h3>
          <div class="space-y-2">
            <a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-slate-700 transition-colors">
              <span>2024</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
            <a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-slate-700 transition-colors">
              <span>2023</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
            <a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-slate-700 transition-colors">
              <span>2022</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
            <a href="#" class="flex justify-between items-center p-2 rounded-lg hover:bg-slate-700 transition-colors">
              <span>2021</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          </div>
        </div>

        <!-- Top by Genre -->
        <div class="bg-slate-800/50 rounded-2xl p-5">
          <h3 class="font-semibold mb-4">Топ за жанрами</h3>
          <div class="flex flex-wrap gap-2">
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Екшн</a>
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Романтика</a>
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Комедія</a>
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Драма</a>
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Фентезі</a>
            <a href="#" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition-colors">Жахи</a>
          </div>
        </div>
      </div>
    </div>
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
