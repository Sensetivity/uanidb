@php $activeNav = 'anime'; @endphp

@extends('main.layouts.app')

@section('title', 'Календар аніме - УкрАніме')

@push('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')

  <!-- Page Header -->
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-10">
      <div class="flex flex-col gap-5">
        <div class="flex items-center gap-3">
          <span class="text-4xl">📅</span>
          <div>
            <h1 class="text-3xl font-bold">Аніме-календар</h1>
            <p class="text-gray-400 mt-0.5">Розклад виходу серій</p>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-sm text-gray-300 hover:text-white transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Попередній тиждень
            </button>
            <span class="font-semibold text-gray-100 px-4 py-2 bg-slate-800/60 rounded-xl text-sm">17–23 лютого 2025</span>
            <button class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-sm text-gray-300 hover:text-white transition-colors">
              Наступний тиждень
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-4 py-2 bg-slate-800/60 rounded-xl text-sm">
              <span class="text-cyan-400 font-semibold">38</span>
              <span class="text-gray-400">аніме</span>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-slate-800/60 rounded-xl text-sm">
              <span class="text-purple-400 font-semibold">142</span>
              <span class="text-gray-400">нових серій</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="border-b border-slate-800 bg-slate-900/60 backdrop-blur-sm sticky top-[73px] z-40">
    <div class="container mx-auto px-4 py-3">
      <div class="flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-2 flex-wrap">
          <button class="px-4 py-2 bg-cyan-500 text-white rounded-xl text-sm font-medium">Всі аніме</button>
          <button class="px-4 py-2 bg-slate-800 text-gray-400 hover:text-white rounded-xl text-sm transition-colors">Дивлюсь</button>
          <button class="px-4 py-2 bg-slate-800 text-gray-400 hover:text-white rounded-xl text-sm transition-colors">Заплановано</button>
          <button class="px-4 py-2 bg-slate-800 text-gray-400 hover:text-white rounded-xl text-sm transition-colors">Переглянуто</button>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-xs text-gray-500">Часовий пояс:</span>
          <select class="py-1.5 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 cursor-pointer">
            <option>Kyiv (UTC+2)</option>
            <option>London (UTC+0)</option>
            <option>New York (UTC-5)</option>
            <option>Tokyo (UTC+9)</option>
            <option>Los Angeles (UTC-8)</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="container mx-auto px-4 py-6">

    <!-- Mobile Day Tabs (lg:hidden) -->
    <div class="lg:hidden mb-6">
      <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-1">
        <button data-day="day-mon" onclick="showDay('day-mon')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Пн</span><span class="text-xs opacity-70">17</span>
        </button>
        <button data-day="day-tue" onclick="showDay('day-tue')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Вт</span><span class="text-xs opacity-70">18</span>
        </button>
        <button data-day="day-wed" onclick="showDay('day-wed')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Ср</span><span class="text-xs opacity-70">19</span>
        </button>
        <button data-day="day-thu" onclick="showDay('day-thu')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-cyan-500 text-white transition-colors min-w-[52px]">
          <span class="flex items-center gap-0.5">Чт <span class="text-cyan-200 text-[10px]">◆</span></span><span class="text-xs opacity-80">20</span>
        </button>
        <button data-day="day-fri" onclick="showDay('day-fri')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Пт</span><span class="text-xs opacity-70">21</span>
        </button>
        <button data-day="day-sat" onclick="showDay('day-sat')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Сб</span><span class="text-xs opacity-70">22</span>
        </button>
        <button data-day="day-sun" onclick="showDay('day-sun')" class="day-tab flex-shrink-0 flex flex-col items-center px-4 py-2.5 rounded-xl text-sm font-medium bg-slate-700 text-gray-400 transition-colors min-w-[52px]">
          <span>Нд</span><span class="text-xs opacity-70">23</span>
        </button>
      </div>
    </div>

    <!-- TODAY SPOTLIGHT -->
    <section class="mb-10">
      <div class="bg-cyan-500/10 border border-cyan-500/20 rounded-2xl p-5 lg:p-6">
        <div class="flex items-start justify-between mb-5">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="text-xl">⚡</span>
              <h2 class="text-xl font-bold text-cyan-400">СЬОГОДНІ — Четвер, 20 лютого</h2>
            </div>
            <p class="text-gray-400 text-sm ml-8">Виходить 8 нових серій та спецвипусків</p>
          </div>
          <span class="hidden sm:inline-flex px-3 py-1 bg-cyan-500/20 text-cyan-400 text-xs font-bold rounded-full border border-cyan-500/30 flex-shrink-0">TODAY</span>
        </div>
        <!-- 3 big spotlight cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

          <!-- Spotlight Card 1: Solo Leveling S2 Ep.8 -->
          <div class="relative group">
            <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/60 rounded-2xl overflow-hidden hover:bg-slate-800 transition-all duration-300">
              <div class="relative aspect-[2/3]">
                <img src="https://placehold.co/300x450/0f172a/3b82f6?text=Solo+Leveling+S2" alt="Solo Leveling S2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                <div class="absolute top-3 left-3">
                  <span class="px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded animate-pulse">НОВА СЕРІЯ</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                  <div class="text-white font-semibold text-sm leading-tight mb-1">Solo Leveling S2</div>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-300 text-xs">Ep.8 • 19:00</span>
                    <span class="text-cyan-400 text-xs font-semibold">★ 8.9</span>
                  </div>
                </div>
              </div>
            </a>
            <!-- + button -->
            <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
            <!-- Hover popup -->
            <div class="absolute left-full top-0 ml-3 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200 hidden lg:block">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <div class="font-semibold text-gray-100 mb-1">Solo Leveling: Reawakening</div>
                <div class="text-xs text-gray-400 mb-3">A-1 Pictures • Екшн, Фентезі</div>
                <div class="flex items-center gap-4 text-xs mb-3">
                  <span class="text-cyan-400 font-bold">★ 8.9</span>
                  <span class="text-gray-400">12 еп.</span>
                  <span class="text-gray-400">Зима 2025</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Sung Jin-Woo — єдиний у світі ранкер без рангу — отримує дивні сили тіней і вирушає до вершини сили мисливців.</p>
              </div>
            </div>
          </div>

          <!-- Spotlight Card 2: Oshi no Ko S2 Ep.10 -->
          <div class="relative group">
            <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/60 rounded-2xl overflow-hidden hover:bg-slate-800 transition-all duration-300">
              <div class="relative aspect-[2/3]">
                <img src="https://placehold.co/300x450/0f172a/a855f7?text=Oshi+no+Ko+S2" alt="Oshi no Ko S2" loading="lazy" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                <div class="absolute top-3 left-3">
                  <span class="px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded animate-pulse">НОВА СЕРІЯ</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                  <div class="text-white font-semibold text-sm leading-tight mb-1">Oshi no Ko S2</div>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-300 text-xs">Ep.10 • 22:00</span>
                    <span class="text-cyan-400 text-xs font-semibold">★ 8.7</span>
                  </div>
                </div>
              </div>
            </a>
            <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
            <div class="absolute left-full top-0 ml-3 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200 hidden lg:block">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <div class="font-semibold text-gray-100 mb-1">Oshi no Ko 2nd Season</div>
                <div class="text-xs text-gray-400 mb-3">Doga Kobo • Драма, Детектив</div>
                <div class="flex items-center gap-4 text-xs mb-3">
                  <span class="text-cyan-400 font-bold">★ 8.7</span>
                  <span class="text-gray-400">13 еп.</span>
                  <span class="text-gray-400">Зима 2025</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Акуамарин і Руубі продовжують розслідування вбивства своєї матері у безжальному світі шоу-бізнесу.</p>
              </div>
            </div>
          </div>

          <!-- Spotlight Card 3: Sakamoto Days Ep.8 -->
          <div class="relative group">
            <a href="{{ route('anime.show', 'example-slug') }}" class="block bg-slate-800/60 rounded-2xl overflow-hidden hover:bg-slate-800 transition-all duration-300">
              <div class="relative aspect-[2/3]">
                <img src="https://placehold.co/300x450/0f172a/22c55e?text=Sakamoto+Days" alt="Sakamoto Days" loading="lazy" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                  <div class="text-white font-semibold text-sm leading-tight mb-1">Sakamoto Days</div>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-300 text-xs">Ep.8 • 23:30</span>
                    <span class="text-cyan-400 text-xs font-semibold">★ 8.5</span>
                  </div>
                </div>
              </div>
            </a>
            <div class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
              <div class="relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </button>
                <div class="list-dropdown hidden absolute top-full right-0 mt-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                  <div class="border-t border-slate-700"></div>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">♥</span> Улюблене</button>
                </div>
              </div>
            </div>
            <div class="absolute right-full top-0 mr-3 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200 hidden lg:block">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <div class="font-semibold text-gray-100 mb-1">Sakamoto Days</div>
                <div class="text-xs text-gray-400 mb-3">TMS Entertainment • Екшн, Комедія</div>
                <div class="flex items-center gap-4 text-xs mb-3">
                  <span class="text-cyan-400 font-bold">★ 8.5</span>
                  <span class="text-gray-400">25 еп.</span>
                  <span class="text-gray-400">Зима 2025</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Колишній найнебезпечніший кілер вирішив піти на пенсію — але минуле та вороги не відпускають.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Weekly Grid -->
    <section>
      <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Розклад на тиждень
      </h2>

      <div class="grid grid-cols-1 lg:grid-cols-7 gap-3">

        <!-- MONDAY -->
        <div id="day-mon" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Пн</div>
            <div class="text-lg font-bold text-gray-100">17</div>
            <div class="text-xs text-gray-500 mt-0.5">2 серії</div>
          </div>
          <div class="space-y-2">

            <!-- Ван Піс -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=ВП" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Ван Піс">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Ван Піс</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.1113 • 09:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.6</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Ван Піс</div>
                  <div class="text-xs text-gray-400 mb-2">Toei Animation • Пригоди, Бойові мистецтва</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.6</span><span class="text-gray-400">1000+ еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Монкі Д. Луффі та його команда шукають легендарний скарб Ван Піс.</p>
                </div>
              </div>
            </div>

            <!-- Mashle S2 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=МШ" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Mashle S2">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Mashle S2</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.5 • 18:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.2</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Mashle: Magic and Muscles S2</div>
                  <div class="text-xs text-gray-400 mb-2">A-1 Pictures • Комедія, Магія</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.2</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Хлопець без магії покладається на чисту м'язову силу у магічному світі.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- TUESDAY -->
        <div id="day-tue" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Вт</div>
            <div class="text-lg font-bold text-gray-100">18</div>
            <div class="text-xs text-gray-500 mt-0.5">2 серії</div>
          </div>
          <div class="space-y-2">

            <!-- Solo Leveling Ep.7 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=SL" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Solo Leveling S2">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Solo Leveling S2</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.7 • 11:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.9</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Solo Leveling S2</div>
                  <div class="text-xs text-gray-400 mb-2">A-1 Pictures • Екшн, Фентезі</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.9</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Sung Jin-Woo отримує силу тіней та стає найсильнішим мисливцем.</p>
                </div>
              </div>
            </div>

            <!-- Dandadan Ep.6 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=DD" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Dandadan">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Dandadan</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.6 • 22:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.8</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Dandadan</div>
                  <div class="text-xs text-gray-400 mb-2">Science SARU • Надприродне, Романтика</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.8</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Окарун і Момо зустрічають паранормальні явища і разом їх досліджують.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- WEDNESDAY -->
        <div id="day-wed" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Ср</div>
            <div class="text-lg font-bold text-gray-100">19</div>
            <div class="text-xs text-gray-500 mt-0.5">3 серії</div>
          </div>
          <div class="space-y-2">

            <!-- Медичний клас -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=МК" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Медичний клас">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Медичний клас</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.6 • 10:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.9</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Медичний клас</div>
                  <div class="text-xs text-gray-400 mb-2">Brain's Base • Медицина, Драма</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.9</span><span class="text-gray-400">13 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Елітна медична школа з унікальними методами та непростими учнями.</p>
                </div>
              </div>
            </div>

            <!-- Frieren Ep.27 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=FR" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Frieren">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Frieren</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.27 • 17:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.1</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Frieren: Beyond Journey's End</div>
                  <div class="text-xs text-gray-400 mb-2">Madhouse • Фентезі, Пригоди</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.1</span><span class="text-gray-400">28 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Ельфійська чарівниця мандрує та рефлексує над плинністю часу.</p>
                </div>
              </div>
            </div>

            <!-- Blue Box Ep.18 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=BB" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Blue Box">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Blue Box</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.18 • 23:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.3</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Blue Box</div>
                  <div class="text-xs text-gray-400 mb-2">Telecom Animation Film • Романтика, Спорт</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.3</span><span class="text-gray-400">25 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Баскетболіст закохується в дівчину-бадмінтоністку, що переїжджає до нього.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- THURSDAY — TODAY -->
        <div id="day-thu" class="day-column bg-cyan-500/10 border border-cyan-500/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-cyan-500/20">
            <div class="text-xs font-bold text-cyan-400 uppercase flex items-center gap-1">Чт <span class="text-[10px]">◆</span></div>
            <div class="text-lg font-bold text-cyan-200">20</div>
            <div class="text-xs text-cyan-500 mt-0.5">6 серій</div>
          </div>
          <div class="space-y-2">

            <!-- Solo Leveling Ep.8 -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/3b82f6?text=SL" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Solo Leveling S2">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Solo Leveling S2</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.8 • 19:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.9</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Solo Leveling S2</div>
                  <div class="text-xs text-gray-400 mb-2">A-1 Pictures • Екшн, Фентезі</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.9</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Sung Jin-Woo отримує силу тіней та стає найсильнішим мисливцем.</p>
                </div>
              </div>
            </div>

            <!-- Oshi no Ko S2 Ep.10 -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/a855f7?text=ONK" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Oshi no Ko S2">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Oshi no Ko S2</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.10 • 22:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.7</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Oshi no Ko S2</div>
                  <div class="text-xs text-gray-400 mb-2">Doga Kobo • Драма, Детектив</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.7</span><span class="text-gray-400">13 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Акуамарин і Руубі розслідують вбивство матері.</p>
                </div>
              </div>
            </div>

            <!-- Sakamoto Days Ep.8 -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/22c55e?text=SD" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Sakamoto Days">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Sakamoto Days</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.8 • 23:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.5</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Sakamoto Days</div>
                  <div class="text-xs text-gray-400 mb-2">TMS Entertainment • Екшн, Комедія</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.5</span><span class="text-gray-400">25 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Колишній найнебезпечніший кілер живе звичайним життям.</p>
                </div>
              </div>
            </div>

            <!-- Haikyuu!! Movie -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/f59e0b?text=HQ" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Haikyuu Movie">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Haikyuu!! FINAL</div>
                <div class="text-xs text-gray-500 mt-0.5">Фільм • 16:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.1</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Haikyuu!! FINAL</div>
                  <div class="text-xs text-gray-400 mb-2">Production I.G • Спорт, Драма</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.1</span><span class="text-gray-400">Фільм</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Фінальна битва команди Карасуно на чемпіонаті.</p>
                </div>
              </div>
            </div>

            <!-- Re:Zero OVA -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/6366f1?text=RZ" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Re:Zero OVA">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Re:Zero OVA</div>
                <div class="text-xs text-gray-500 mt-0.5">OVA • 20:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.9</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Re:Zero OVA</div>
                  <div class="text-xs text-gray-400 mb-2">White Fox • Фентезі, Психологія</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.9</span><span class="text-gray-400">OVA</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Спеціальний випуск до Re:Zero.</p>
                </div>
              </div>
            </div>

            <!-- Zenshu Ep.8 -->
            <div class="relative group flex items-center gap-2 p-2 bg-cyan-500/10 border border-cyan-500/10 rounded-xl hover:bg-cyan-500/20 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/0c1929/ec4899?text=ZS" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Zenshu">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-100">Zenshu</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.8 • 21:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.0</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Zenshu</div>
                  <div class="text-xs text-gray-400 mb-2">Wit Studio • Комедія, Романтика</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.0</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Молода жінка переміщується у світ старого аніме.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- FRIDAY -->
        <div id="day-fri" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Пт</div>
            <div class="text-lg font-bold text-gray-100">21</div>
            <div class="text-xs text-gray-500 mt-0.5">4 серії</div>
          </div>
          <div class="space-y-2">

            <!-- Dungeon Meshi -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=DM" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Dungeon Meshi">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Dungeon Meshi</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.23 • 12:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.0</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Dungeon Meshi</div>
                  <div class="text-xs text-gray-400 mb-2">Trigger • Пригоди, Кулінарія</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.0</span><span class="text-gray-400">24 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Лайос і команда мисливців готують монстрів та рятують сестру.</p>
                </div>
              </div>
            </div>

            <!-- Apothecary Diaries -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=AP" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Apothecary Diaries">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Apothecary Diaries</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.19 • 17:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.7</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Apothecary Diaries</div>
                  <div class="text-xs text-gray-400 mb-2">TOHO Animation • Містерія, Драма</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.7</span><span class="text-gray-400">24 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Дівчина-фармацевт розкриває інтриги імператорського двору.</p>
                </div>
              </div>
            </div>

            <!-- Spy x Family -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=SxF" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Spy x Family">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Spy x Family</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.18 • 20:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.4</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Spy x Family</div>
                  <div class="text-xs text-gray-400 mb-2">Wit Studio • Комедія, Екшн</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.4</span><span class="text-gray-400">25 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Шпигун, вбивця та телепат живуть разом як фальшива сім'я.</p>
                </div>
              </div>
            </div>

            <!-- Yakuza Fiancé -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=YF" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Yakuza Fiancé">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Yakuza Fiancé</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.6 • 23:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.8</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Yakuza Fiancé</div>
                  <div class="text-xs text-gray-400 mb-2">DLE • Романтика</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.8</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Нестандартна романтика дівчини та спадкоємця якудза.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- SATURDAY -->
        <div id="day-sat" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Сб</div>
            <div class="text-lg font-bold text-gray-100">22</div>
            <div class="text-xs text-gray-500 mt-0.5">6 серій</div>
          </div>
          <div class="space-y-2">

            <!-- Frieren Ep.28 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=FR" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Frieren">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Frieren</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.28 • 11:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.1</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Frieren: Beyond Journey's End</div>
                  <div class="text-xs text-gray-400 mb-2">Madhouse • Фентезі, Пригоди</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.1</span><span class="text-gray-400">28 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Фінальна серія — ельфійська магиня завершує свою подорож.</p>
                </div>
              </div>
            </div>

            <!-- Demon Slayer Hashira -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=DS" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Demon Slayer">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Demon Slayer: Hashira</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.1 • 14:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.2</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Demon Slayer: Hashira Training</div>
                  <div class="text-xs text-gray-400 mb-2">ufotable • Екшн, Надприродне</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.2</span><span class="text-gray-400">8 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Танджіро проходить тренування Стовпів.</p>
                </div>
              </div>
            </div>

            <!-- Naruto New Era -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=NE" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Naruto New Era">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Naruto: New Era</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.52 • 09:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.5</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Naruto: New Era</div>
                  <div class="text-xs text-gray-400 mb-2">Pierrot • Ніндзя, Екшн</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.5</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Нова ера Нарутовсесвіту з новим поколінням ніндзя.</p>
                </div>
              </div>
            </div>

            <!-- MHA S7 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=MHA" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="My Hero Academia S7">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">My Hero Academia S7</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.12 • 17:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.0</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">My Hero Academia S7</div>
                  <div class="text-xs text-gray-400 mb-2">Bones • Супергерої, Екшн</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.0</span><span class="text-gray-400">21 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Ізуку Мідорія у фінальній боротьбі за суспільство.</p>
                </div>
              </div>
            </div>

            <!-- Bucchigiri -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=BG" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Bucchigiri">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Bucchigiri?!</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.7 • 20:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.7</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Bucchigiri?!</div>
                  <div class="text-xs text-gray-400 mb-2">MAPPA • Екшн, Надприродне</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.7</span><span class="text-gray-400">13 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Студент потрапляє у вуличні бійки після отримання надприродної сили.</p>
                </div>
              </div>
            </div>

            <!-- Classroom of the Elite S3 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=CE" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Classroom of the Elite S3">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Classroom of the Elite S3</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.7 • 22:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.6</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Classroom of the Elite S3</div>
                  <div class="text-xs text-gray-400 mb-2">Lerche • Психологія, Школа</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.6</span><span class="text-gray-400">13 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Хіяма Кійотака продовжує психологічні ігри в елітній школі.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- SUNDAY -->
        <div id="day-sun" class="day-column hidden lg:block bg-slate-900/30 rounded-xl p-3">
          <div class="mb-3 pb-2 border-b border-slate-800">
            <div class="text-xs font-bold text-gray-400 uppercase">Нд</div>
            <div class="text-lg font-bold text-gray-100">23</div>
            <div class="text-xs text-gray-500 mt-0.5">6 серій</div>
          </div>
          <div class="space-y-2">

            <!-- Mushoku Tensei S2 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=MT" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Mushoku Tensei S2">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Mushoku Tensei S2</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.8 • 10:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.8</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Mushoku Tensei S2</div>
                  <div class="text-xs text-gray-400 mb-2">Studio Bind • Ісекай, Магія</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.8</span><span class="text-gray-400">12 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Рудеус Грейрет продовжує своє перевтілення у магічному світі.</p>
                </div>
              </div>
            </div>

            <!-- One Punch Man S3 -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=OPM" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="One Punch Man S3">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">One Punch Man S3</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.5 • 13:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.0</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">One Punch Man S3</div>
                  <div class="text-xs text-gray-400 mb-2">J.C.Staff • Комедія, Супергерої</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.0</span><span class="text-gray-400">24 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Сайтама перемагає ворогів одним ударом.</p>
                </div>
              </div>
            </div>

            <!-- Dragon Ball Daima -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=DBD" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Dragon Ball Daima">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Dragon Ball Daima</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.18 • 09:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 8.1</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Dragon Ball Daima</div>
                  <div class="text-xs text-gray-400 mb-2">Toei Animation • Екшн, Пригоди</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 8.1</span><span class="text-gray-400">20 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Гоку та друзі перетворюються на дітей і вирушають у нові пригоди.</p>
                </div>
              </div>
            </div>

            <!-- Jujutsu Kaisen OVA -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=JJK" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Jujutsu Kaisen OVA">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Jujutsu Kaisen OVA</div>
                <div class="text-xs text-gray-500 mt-0.5">OVA • 15:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 9.3</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Jujutsu Kaisen S2 OVA</div>
                  <div class="text-xs text-gray-400 mb-2">MAPPA • Надприродне, Екшн</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 9.3</span><span class="text-gray-400">OVA</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Спеціальний епізод до другого сезону Дзюдзюцу Кайсен.</p>
                </div>
              </div>
            </div>

            <!-- Shangri-La Frontier -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=SLF" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Shangri-La Frontier">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Shangri-La Frontier</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.7 • 19:00</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.6</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Shangri-La Frontier</div>
                  <div class="text-xs text-gray-400 mb-2">C2C • Ігри, Пригоди</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.6</span><span class="text-gray-400">25 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Геймер занурюється у відеоігри з повним зануренням.</p>
                </div>
              </div>
            </div>

            <!-- Metallic Rouge -->
            <div class="relative group flex items-center gap-2 p-2 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer">
              <img src="https://placehold.co/40x56/1e293b/94a3b8?text=MR" class="w-10 h-14 object-cover rounded-lg flex-shrink-0" loading="lazy" alt="Metallic Rouge">
              <div class="flex-grow min-w-0">
                <div class="text-xs font-medium line-clamp-2 text-gray-200">Metallic Rouge</div>
                <div class="text-xs text-gray-500 mt-0.5">Ep.6 • 21:30</div>
                <div class="text-xs text-cyan-400 mt-0.5">★ 7.4</div>
              </div>
              <div class="list-menu-container flex-shrink-0 relative">
                <button type="button" onclick="toggleListMenu(event, this)" class="opacity-0 group-hover:opacity-100 w-6 h-6 bg-slate-700 hover:bg-cyan-500 rounded-md flex items-center justify-center transition-all text-xs font-bold text-gray-300 leading-none">+</button>
                <div class="list-dropdown hidden absolute right-0 top-full mt-1 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50" onclick="event.stopPropagation()">
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-cyan-400">▶</span> Дивлюсь</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-amber-400">📋</span> Заплановано</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3"><span class="text-green-400">✓</span> Переглянуто</button>
                  <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3"><span class="text-red-400">✗</span> Кинув</button>
                </div>
              </div>
              <div class="absolute right-full top-0 mr-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                  <div class="font-semibold text-gray-100 text-sm mb-1">Metallic Rouge</div>
                  <div class="text-xs text-gray-400 mb-2">Bones • Sci-Fi, Екшн</div>
                  <div class="flex items-center gap-3 text-xs mb-2"><span class="text-cyan-400 font-bold">★ 7.4</span><span class="text-gray-400">13 еп.</span></div>
                  <p class="text-xs text-gray-400 line-clamp-2">Роботи-неолюди борються за своє існування у людському суспільстві.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>

  </div>

  <!-- Footer -->
@endsection

@push('scripts')
@include('main.components.list-menu-script')
<script>
    function showDay(dayId) {
      document.querySelectorAll('.day-column').forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('.day-tab').forEach(el => {
        el.classList.remove('bg-cyan-500', 'text-white');
        el.classList.add('bg-slate-700', 'text-gray-400');
      });
      document.getElementById(dayId).classList.remove('hidden');
      const activeTab = document.querySelector('[data-day="' + dayId + '"]');
      if (activeTab) {
        activeTab.classList.remove('bg-slate-700', 'text-gray-400');
        activeTab.classList.add('bg-cyan-500', 'text-white');
      }
    }
</script>
@endpush
