@php $activeNav = 'anime'; @endphp

@extends('main.layouts.app')

@section('title', 'Аніме список - УкрАніме')


@section('content')

  <!-- Page Header -->
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Каталог аніме</h1>
      <p class="text-gray-400">Знайдіть та досліджуйте понад 21,000 аніме</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Filters Sidebar -->
      <div class="w-full lg:w-72 flex-shrink-0">
        <div class="bg-slate-900/50 rounded-2xl p-5 sticky top-24">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold">Фільтри</h3>
            <button class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">Скинути</button>
          </div>

          <!-- Search -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-2">Пошук</label>
            <input type="text" placeholder="Назва аніме..." class="w-full py-2.5 px-4 rounded-xl bg-slate-800 border border-slate-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:border-cyan-500 transition-all">
          </div>

          <!-- Type -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-3">Тип</label>
            <div class="flex flex-wrap gap-2">
              <button class="px-3 py-1.5 bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 rounded-lg text-sm font-medium">ТБ</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 transition-colors">Фільм</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 transition-colors">OVA</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 transition-colors">ONA</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 transition-colors">Спешл</button>
            </div>
          </div>

          <!-- Status -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-3">Статус</label>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0">
                <span class="text-gray-300 group-hover:text-gray-100 transition-colors">Виходить</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0">
                <span class="text-gray-300 group-hover:text-gray-100 transition-colors">Завершено</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0">
                <span class="text-gray-300 group-hover:text-gray-100 transition-colors">Анонсовано</span>
              </label>
            </div>
          </div>

          <!-- Genres -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-3">Жанри</label>
            <div class="flex flex-wrap gap-2">
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Екшн</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Пригоди</button>
              <button class="px-3 py-1.5 bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 rounded-lg text-sm font-medium">Комедія</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Драма</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Фентезі</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Романтика</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Психологія</button>
              <button class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-lg text-sm text-gray-400 hover:text-gray-200 hover:border-slate-600 transition-colors">Жахи</button>
            </div>
            <button class="text-sm text-cyan-400 hover:text-cyan-300 mt-3 transition-colors">Усі жанри...</button>
          </div>

          <!-- Year -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-3">Рік</label>
            <div class="flex gap-3">
              <select class="flex-1 py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
                <option>Від</option>
                <option>2025</option>
                <option>2024</option>
                <option>2023</option>
                <option>2022</option>
                <option>2020</option>
                <option>2015</option>
                <option>2010</option>
                <option>2000</option>
              </select>
              <select class="flex-1 py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
                <option>До</option>
                <option>2025</option>
                <option>2024</option>
                <option>2023</option>
                <option>2022</option>
                <option>2020</option>
                <option>2015</option>
                <option>2010</option>
              </select>
            </div>
          </div>

          <!-- Season -->
          <div class="mb-6">
            <label class="block text-sm text-gray-400 mb-3">Сезон</label>
            <select class="w-full py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
              <option>Будь-який</option>
              <option>Зима 2025</option>
              <option>Осінь 2024</option>
              <option>Літо 2024</option>
              <option>Весна 2024</option>
            </select>
          </div>

          <!-- Apply Button -->
          <button class="w-full py-3 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-semibold hover:opacity-90 transition-opacity">
            Застосувати фільтри
          </button>
        </div>
      </div>

      <!-- Anime List -->
      <div class="flex-grow">
        <!-- Sort & View Options -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <span class="text-gray-500">Знайдено: <span class="text-gray-200">8,432</span> аніме</span>
          </div>
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-500">Сортувати:</span>
              <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
                <option>Популярність</option>
                <option>Рейтинг</option>
                <option>Новизна</option>
                <option>Назва (А-Я)</option>
                <option>Назва (Я-А)</option>
              </select>
            </div>
            <div class="flex items-center gap-1">
              <a href="{{ route('anime.index') }}" class="p-2 rounded-lg bg-slate-800 text-gray-400 hover:text-gray-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
              </a>
              <a href="{{ route('anime.list-view') }}" class="p-2 rounded-lg bg-cyan-500/20 text-cyan-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- List View -->
        <div class="space-y-4">
          <!-- Item 1 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Frieren: Похоронний обряд</h4>
                <p class="text-xs text-gray-500 mb-3">Madhouse • Осінь 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.4</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">28 еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.4</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-green-500/80 text-xs rounded">Виходить</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Ельфійська маг Фрірен подорожує світом після перемоги над Королем демонів, шукаючи сенс свого безсмертного життя та спогади про своїх товаришів.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>28 епізодів</span>
                  <span>Осінь 2023</span>
                  <span>Madhouse</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Пригоди</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Драма</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Фентезі</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 2 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Solo Leveling</h4>
                <p class="text-xs text-gray-500 mb-3">A-1 Pictures • Зима 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.2</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">12 еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Solo+Leveling" alt="Solo Leveling" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.2</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Solo Leveling</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-green-500/80 text-xs rounded">Виходить</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Сон Джін-У, найслабший мисливець E-рангу, отримує унікальну здатність підвищувати рівень після таємничої події в підземеллі.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>12 епізодів</span>
                  <span>Зима 2024</span>
                  <span>A-1 Pictures</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Пригоди</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Фентезі</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 3 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Дзюцу Кайсен S2</h4>
                <p class="text-xs text-gray-500 mb-3">MAPPA • Літо 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 8.9</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">23 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Фентезі</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Надприродне</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Jujutsu" alt="Jujutsu Kaisen" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.9</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Дзюцу Кайсен S2</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Продовження історії Юдзі Ітадорі та його друзів у боротьбі з прокляттями. Другий сезон розповідає про минуле Годзьо Сатору та інцидент у Сібуї.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>23 епізоди</span>
                  <span>Літо 2023</span>
                  <span>MAPPA</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Фентезі</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Надприродне</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 4 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Клинок, що знищує демонів S4</h4>
                <p class="text-xs text-gray-500 mb-3">ufotable • Весна 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.1</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">8 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Демони</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Demon+Slayer" alt="Demon Slayer" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.1</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Клинок, що знищує демонів S4</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Танджіро продовжує свою подорож як мисливець на демонів. Четвертий сезон зосереджений на тренуванні з Стовпами Корпусу.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>8 епізодів</span>
                  <span>Весна 2024</span>
                  <span>ufotable</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Демони</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Історичний</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 5 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Ван Піс</h4>
                <p class="text-xs text-gray-500 mb-3">Toei Animation • 1999</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 8.8</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">1095+ еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=One+Piece" alt="One Piece" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.8</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Ван Піс</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-green-500/80 text-xs rounded">Виходить</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Пірат Монкі Д. Луффі та його команда Мугівар вирушають у пошуках легендарного скарбу One Piece, щоб Луффі став Королем Піратів.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>1095+ епізодів</span>
                  <span>1999</span>
                  <span>Toei Animation</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Пригоди</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Комедія</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 6 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Атака Титанів: Фінал</h4>
                <p class="text-xs text-gray-500 mb-3">MAPPA • Осінь 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.0</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">16 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Attack+on+Titan" alt="Attack on Titan" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.0</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Атака Титанів: Фінал</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Завершальна частина епічної саги про боротьбу людства проти титанів. Ерен Єгер приймає фінальне рішення, що визначить долю світу.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>16 епізодів</span>
                  <span>Осінь 2023</span>
                  <span>MAPPA</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Драма</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Фентезі</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 7 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Spy x Family S2</h4>
                <p class="text-xs text-gray-500 mb-3">Wit Studio • Осінь 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 8.7</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">12 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Комедія</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Spy+x+Family" alt="Spy x Family" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.7</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Spy x Family S2</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Шпигун, вбивця та телепат утворюють фальшиву сім'ю для виконання секретної місії. Другий сезон продовжує їхні кумедні пригоди.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>12 епізодів</span>
                  <span>Осінь 2023</span>
                  <span>Wit Studio, CloverWorks</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Комедія</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Сім'я</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 8 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Людина-бензопила</h4>
                <p class="text-xs text-gray-500 mb-3">MAPPA • Осінь 2022</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 8.6</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">12 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Жахи</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Chainsaw+Man" alt="Chainsaw Man" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.6</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Людина-бензопила</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Денджі, бідний хлопець із собакою-демоном Почитою, стає Людиною-бензопилою і приєднується до урядової організації мисливців на демонів.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>12 епізодів</span>
                  <span>Осінь 2022</span>
                  <span>MAPPA</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Екшн</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Жахи</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Надприродне</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 9 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Віолетта Евергарден</h4>
                <p class="text-xs text-gray-500 mb-3">Kyoto Animation • Зима 2018</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 9.0</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">13 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Violet" alt="Violet Evergarden" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.0</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Віолетта Евергарден</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Колишня дитина-солдат Віолетта шукає сенс слів «Я кохаю тебе», працюючи автоспогадовою лялькою та пишучи листи для інших людей.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>13 епізодів</span>
                  <span>Зима 2018</span>
                  <span>Kyoto Animation</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Драма</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Фентезі</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Повсякденність</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>

          <!-- Item 10 -->
          <div class="relative group">
            <div class="absolute left-36 bottom-full mb-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Oshi no Ko S2</h4>
                <p class="text-xs text-gray-500 mb-3">Doga Kobo • Літо 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm">
                  <span class="text-cyan-400 font-bold">★ 8.7</span>
                  <span class="text-gray-400">ТБ</span>
                  <span class="text-gray-400">13 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1">
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Надприродне</span>
                </div>
              </div>
            </div>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 bg-slate-900/50 rounded-xl p-4 pr-14 hover:bg-slate-800/50 transition-colors">
              <div class="relative flex-shrink-0 w-24 sm:w-32">
                <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Oshi+no+Ko" alt="Oshi no Ko" loading="lazy" class="w-full aspect-[3/4] object-cover rounded-lg">
                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.7</div>
              </div>
              <div class="flex-grow min-w-0">
                <div class="flex items-start justify-between gap-4 mb-2">
                  <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">Oshi no Ko S2</h3>
                  <div class="flex gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 bg-slate-700 text-xs rounded">ТБ</span>
                    <span class="px-2 py-0.5 bg-blue-500/80 text-xs rounded">Завершено</span>
                  </div>
                </div>
                <p class="text-sm text-gray-400 mb-3 line-clamp-2">Аква продовжує своє розслідування смерті матері, поринаючи глибше в темну сторону індустрії розваг Японії. Другий сезон адаптує арку театральної постановки.</p>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-500">
                  <span>13 епізодів</span>
                  <span>Літо 2024</span>
                  <span>Doga Kobo</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Драма</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Надприродне</span>
                  <span class="px-2 py-1 bg-slate-800 text-xs text-gray-400 rounded">Реінкарнація</span>
                </div>
              </div>
            </a>
            @include('main.components.anime-list-menu')
          </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-10">
          <nav class="flex items-center gap-2">
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-500 text-white font-medium">1</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700 transition-colors">2</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700 transition-colors">3</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700 transition-colors">4</button>
            <span class="text-gray-500 px-2">...</span>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700 transition-colors">422</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
@endsection

@push('scripts')
@include('main.components.list-menu-script')
@endpush
