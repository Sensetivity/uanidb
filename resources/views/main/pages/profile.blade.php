@extends('main.layouts.app')

@section('title', 'Профіль - УкрАніме')

@php $activeNav = ''; @endphp

@push('styles')
<style>
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
  <!-- Profile Header -->
  <div class="bg-gradient-to-r from-cyan-500/10 via-purple-500/10 to-pink-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <div class="flex flex-col md:flex-row gap-6 items-start md:items-end">
        <!-- Avatar -->
        <div class="relative">
          <img src="https://placehold.co/160x160/1e293b/94a3b8?text=Avatar" alt="Avatar" class="w-32 h-32 md:w-40 md:h-40 rounded-2xl border-4 border-slate-800 shadow-xl">
          <div class="absolute -bottom-2 -right-2 px-3 py-1 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full text-sm font-bold">
            Lv.12
          </div>
        </div>
        <!-- User Info -->
        <div class="flex-grow">
          <div class="flex flex-wrap items-center gap-3 mb-2">
            <h1 class="text-3xl font-bold">AnimeFan2025</h1>
            <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm font-medium">Отаку</span>
            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-400 rounded-full text-sm font-medium">Рецензент</span>
          </div>
          <p class="text-gray-400 mb-4 max-w-2xl">Люблю аніме з глибоким сюжетом та цікавими персонажами. Улюблені жанри: фентезі, психологія, драма. Завжди радий обговорити нові тайтли!</p>
          <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
            <span class="flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Приєднався: Березень 2023
            </span>
            <span class="flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Україна, Київ
            </span>
            <span class="flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Останній візит: Сьогодні
            </span>
          </div>
        </div>
        <!-- Action Buttons -->
        <div class="flex gap-3">
          <a href="#" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl font-medium transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Налаштування
          </a>
          <button class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium hover:opacity-90 transition-opacity flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Редагувати
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Bar -->
  <div class="bg-slate-900/50 border-b border-slate-800">
    <div class="container mx-auto px-4 py-6">
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        <div class="text-center">
          <p class="text-2xl font-bold text-cyan-400">247</p>
          <p class="text-sm text-gray-500">Переглянуто</p>
        </div>
        <div class="text-center">
          <p class="text-2xl font-bold text-green-400">12</p>
          <p class="text-sm text-gray-500">Дивлюсь</p>
        </div>
        <div class="text-center">
          <p class="text-2xl font-bold text-purple-400">89</p>
          <p class="text-sm text-gray-500">Заплановано</p>
        </div>
        <div class="text-center">
          <p class="text-2xl font-bold text-amber-400">3,842</p>
          <p class="text-sm text-gray-500">Епізодів</p>
        </div>
        <div class="text-center">
          <p class="text-2xl font-bold text-pink-400">64.2</p>
          <p class="text-sm text-gray-500">Днів</p>
        </div>
        <div class="text-center">
          <p class="text-2xl font-bold text-orange-400">8.4</p>
          <p class="text-sm text-gray-500">Сер. оцінка</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Left Column -->
      <div class="lg:w-80 flex-shrink-0 space-y-6">
        <!-- Achievements -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Досягнення</h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Усі</a>
          </div>
          <div class="grid grid-cols-4 gap-3">
            <div class="group relative">
              <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>🏆</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                100 аніме
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>📝</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                50 рецензій
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>⭐</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                1000 оцінок
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>🎬</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                Марафонець
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>🌟</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                Перший рік
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-2xl">
                <span>❤️</span>
              </div>
              <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                100 улюблених
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-slate-700/50 rounded-xl flex items-center justify-center text-2xl opacity-40">
                <span>🔒</span>
              </div>
            </div>
            <div class="group relative">
              <div class="w-12 h-12 bg-slate-700/50 rounded-xl flex items-center justify-center text-2xl opacity-40">
                <span>🔒</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Favorite Genres -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <h3 class="font-semibold mb-4">Улюблені жанри</h3>
          <div class="space-y-3">
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span>Фентезі</span>
                <span class="text-gray-500">68 аніме</span>
              </div>
              <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: 85%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span>Драма</span>
                <span class="text-gray-500">54 аніме</span>
              </div>
              <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: 70%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span>Екшн</span>
                <span class="text-gray-500">47 аніме</span>
              </div>
              <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: 60%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span>Психологія</span>
                <span class="text-gray-500">32 аніме</span>
              </div>
              <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: 45%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span>Романтика</span>
                <span class="text-gray-500">28 аніме</span>
              </div>
              <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full" style="width: 38%"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Favorite Characters -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Улюблені персонажі</h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Усі</a>
          </div>
          <div class="space-y-3">
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-colors">
              <img src="https://placehold.co/50x50/1e293b/94a3b8?text=F" alt="Frieren" class="w-12 h-12 rounded-lg object-cover" loading="lazy">
              <div>
                <p class="font-medium">Фрірен</p>
                <p class="text-sm text-gray-500">Frieren</p>
              </div>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-colors">
              <img src="https://placehold.co/50x50/1e293b/94a3b8?text=L" alt="Levi" class="w-12 h-12 rounded-lg object-cover" loading="lazy">
              <div>
                <p class="font-medium">Леві Аккерман</p>
                <p class="text-sm text-gray-500">Attack on Titan</p>
              </div>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-colors">
              <img src="https://placehold.co/50x50/1e293b/94a3b8?text=V" alt="Violet" class="w-12 h-12 rounded-lg object-cover" loading="lazy">
              <div>
                <p class="font-medium">Віолетта Евергарден</p>
                <p class="text-sm text-gray-500">Violet Evergarden</p>
              </div>
            </a>
          </div>
        </div>

        <!-- Social Links -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <h3 class="font-semibold mb-4">Соціальні мережі</h3>
          <div class="space-y-2">
            <a href="#" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-colors text-gray-400 hover:text-gray-200">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              <span>@animefan2025</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-800/50 transition-colors text-gray-400 hover:text-gray-200">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
              <span>AnimeFan#2025</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="flex-grow space-y-6">
        <!-- Tabs -->
        <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
          <button class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium whitespace-nowrap">Огляд</button>
          <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors whitespace-nowrap">Список аніме</button>
          <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors whitespace-nowrap">Улюблене</button>
          <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors whitespace-nowrap">Рецензії</button>
          <button class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors whitespace-nowrap">Активність</button>
        </div>

        <!-- Currently Watching -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold flex items-center gap-2">
              <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
              Зараз дивлюсь
            </h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Усі (12)</a>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Solo" alt="Solo Leveling" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-2 right-2">
                  <div class="flex items-center justify-between text-xs">
                    <span class="px-2 py-0.5 bg-green-500/80 rounded">Еп. 8/12</span>
                  </div>
                </div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Solo Leveling</h4>
              <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                <div class="bg-cyan-500 h-1 rounded-full" style="width: 66%"></div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-2 right-2">
                  <div class="flex items-center justify-between text-xs">
                    <span class="px-2 py-0.5 bg-green-500/80 rounded">Еп. 24/28</span>
                  </div>
                </div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Frieren</h4>
              <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                <div class="bg-cyan-500 h-1 rounded-full" style="width: 86%"></div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Apothecary" alt="Apothecary Diaries" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-2 right-2">
                  <div class="flex items-center justify-between text-xs">
                    <span class="px-2 py-0.5 bg-green-500/80 rounded">Еп. 18/24</span>
                  </div>
                </div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Записки аптекарки</h4>
              <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                <div class="bg-cyan-500 h-1 rounded-full" style="width: 75%"></div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Mashle" alt="Mashle" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-2 right-2">
                  <div class="flex items-center justify-between text-xs">
                    <span class="px-2 py-0.5 bg-green-500/80 rounded">Еп. 5/12</span>
                  </div>
                </div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Mashle S2</h4>
              <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                <div class="bg-cyan-500 h-1 rounded-full" style="width: 42%"></div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Dungeon" alt="Dungeon Meshi" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-2 right-2">
                  <div class="flex items-center justify-between text-xs">
                    <span class="px-2 py-0.5 bg-green-500/80 rounded">Еп. 10/24</span>
                  </div>
                </div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Їжа в підземеллі</h4>
              <div class="w-full bg-slate-700 rounded-full h-1 mt-1">
                <div class="bg-cyan-500 h-1 rounded-full" style="width: 42%"></div>
              </div>
            </a>
          </div>
        </div>

        <!-- Favorite Anime -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              Улюблене аніме
            </h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Усі (24)</a>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Steins" alt="Steins;Gate" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">10</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Steins;Gate</h4>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=FMAB" alt="FMA Brotherhood" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">10</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">FMA: Brotherhood</h4>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=AoT" alt="Attack on Titan" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">10</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Атака Титанів</h4>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Violet" alt="Violet Evergarden" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">10</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Violet Evergarden</h4>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Monster" alt="Monster" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Monster</h4>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="group">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/160x220/1e293b/94a3b8?text=Mob" alt="Mob Psycho" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9</div>
              </div>
              <h4 class="font-medium text-sm group-hover:text-cyan-400 transition-colors line-clamp-1">Mob Psycho 100</h4>
            </a>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Остання активність</h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Уся історія</a>
          </div>
          <div class="space-y-4">
            <!-- Activity Item -->
            <div class="flex gap-4 p-3 rounded-xl hover:bg-slate-800/30 transition-colors">
              <div class="flex-shrink-0 w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="flex-grow">
                <p class="text-sm">
                  Переглянув <a href="{{ route('anime.show', 'example-slug') }}" class="text-cyan-400 hover:underline">Solo Leveling</a> епізод 8
                </p>
                <p class="text-xs text-gray-500 mt-1">2 години тому</p>
              </div>
            </div>
            <!-- Activity Item -->
            <div class="flex gap-4 p-3 rounded-xl hover:bg-slate-800/30 transition-colors">
              <div class="flex-shrink-0 w-10 h-10 bg-amber-500/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
              </div>
              <div class="flex-grow">
                <p class="text-sm">
                  Оцінив <a href="{{ route('anime.show', 'example-slug') }}" class="text-cyan-400 hover:underline">Frieren: Похоронний обряд</a> на <span class="text-amber-400 font-bold">10</span>
                </p>
                <p class="text-xs text-gray-500 mt-1">5 годин тому</p>
              </div>
            </div>
            <!-- Activity Item -->
            <div class="flex gap-4 p-3 rounded-xl hover:bg-slate-800/30 transition-colors">
              <div class="flex-shrink-0 w-10 h-10 bg-pink-500/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
              </div>
              <div class="flex-grow">
                <p class="text-sm">
                  Додав до улюблених <a href="{{ route('anime.show', 'example-slug') }}" class="text-cyan-400 hover:underline">Frieren: Похоронний обряд</a>
                </p>
                <p class="text-xs text-gray-500 mt-1">5 годин тому</p>
              </div>
            </div>
            <!-- Activity Item -->
            <div class="flex gap-4 p-3 rounded-xl hover:bg-slate-800/30 transition-colors">
              <div class="flex-shrink-0 w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </div>
              <div class="flex-grow">
                <p class="text-sm">
                  Написав рецензію на <a href="{{ route('anime.show', 'example-slug') }}" class="text-cyan-400 hover:underline">Атака Титанів: Фінал</a>
                </p>
                <p class="text-xs text-gray-500 mt-1">Вчора</p>
              </div>
            </div>
            <!-- Activity Item -->
            <div class="flex gap-4 p-3 rounded-xl hover:bg-slate-800/30 transition-colors">
              <div class="flex-shrink-0 w-10 h-10 bg-cyan-500/20 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <div class="flex-grow">
                <p class="text-sm">
                  Додав <a href="{{ route('anime.show', 'example-slug') }}" class="text-cyan-400 hover:underline">Dungeon Meshi</a> до списку "Дивлюсь"
                </p>
                <p class="text-xs text-gray-500 mt-1">2 дні тому</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Reviews -->
        <div class="bg-slate-900/50 rounded-2xl p-5">
          <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Останні рецензії</h3>
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Усі (47)</a>
          </div>
          <div class="space-y-4">
            <!-- Review Card -->
            <div class="p-4 bg-slate-800/30 rounded-xl">
              <div class="flex gap-4 mb-3">
                <img src="https://placehold.co/80x110/1e293b/94a3b8?text=AoT" alt="Attack on Titan" class="w-16 h-22 rounded-lg object-cover flex-shrink-0" loading="lazy">
                <div>
                  <a href="{{ route('anime.show', 'example-slug') }}" class="font-semibold hover:text-cyan-400 transition-colors">Атака Титанів: Фінал</a>
                  <div class="flex items-center gap-2 mt-1">
                    <div class="flex">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <span class="text-sm text-gray-500">10/10</span>
                  </div>
                  <p class="text-xs text-gray-500 mt-1">Вчора</p>
                </div>
              </div>
              <p class="text-sm text-gray-300 line-clamp-3">Епічне завершення однієї з найкращих аніме-серій десятиліття. Ісаяма створив справжній шедевр, який змушує задуматися про природу війни, свободи та людяності. Фінальний сезон підняв ставки на неймовірну висоту...</p>
              <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                <span class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                  </svg>
                  128
                </span>
                <span class="flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                  </svg>
                  24
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
