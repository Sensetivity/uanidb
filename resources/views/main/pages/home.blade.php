@php $activeNav = ''; @endphp

@extends('main.layouts.app')

@section('title', 'УкрАніме - Українська База Аніме')

@section('content')
  <!-- Hero Section -->
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-purple-500/10 to-pink-500/10"></div>
    <div class="absolute inset-0">
      <div class="absolute top-20 left-10 w-72 h-72 bg-cyan-500/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 py-16 relative">
      <div class="flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2 text-center lg:text-left">
          <span class="inline-block px-4 py-1.5 bg-cyan-500/20 text-cyan-400 rounded-full text-sm font-medium mb-6">
            Сезон Зима 2025
          </span>
          <h1 class="text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
            Відкрийте світ
            <span class="bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
              аніме
            </span>
            українською
          </h1>
          <p class="text-xl text-gray-400 mb-8 max-w-lg">
            Найбільша українська база даних аніме, манґи, персонажів та сейю. Понад 20,000 тайтлів.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
            <a href="{{ route('anime.index') }}" class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-semibold text-lg hover:opacity-90 transition-opacity">
              Переглянути аніме
            </a>
            <a href="{{ route('seasons') }}" class="px-8 py-4 bg-slate-800 border border-slate-700 rounded-xl font-semibold text-lg hover:bg-slate-700 transition-colors">
              Новий сезон
            </a>
          </div>
        </div>
        <div class="lg:w-1/2">
          <div class="grid grid-cols-3 gap-4">
            <div class="space-y-4">
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <div class="gradient-border rounded-2xl">
                  <img src="https://placehold.co/200x280/1e293b/94a3b8?text=Attack+on+Titan" alt="Атака Титанів" class="rounded-2xl w-full">
                </div>
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <img src="https://placehold.co/200x280/1e293b/94a3b8?text=Jujutsu" alt="Дзюцу Кайсен" class="rounded-2xl w-full" loading="lazy">
              </a>
            </div>
            <div class="space-y-4 pt-8">
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <img src="https://placehold.co/200x280/1e293b/94a3b8?text=Demon+Slayer" alt="Клинок" class="rounded-2xl w-full" loading="lazy">
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <img src="https://placehold.co/200x280/1e293b/94a3b8?text=SPY+x+FAMILY" alt="Spy x Family" class="rounded-2xl w-full" loading="lazy">
              </a>
            </div>
            <div class="space-y-4 pt-16">
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <img src="https://placehold.co/200x280/1e293b/94a3b8?text=One+Piece" alt="Ван Піс" class="rounded-2xl w-full" loading="lazy">
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="block card-hover">
                <img src="https://placehold.co/200x280/1e293b/94a3b8?text=Chainsaw" alt="Людина-бензопила" class="rounded-2xl w-full" loading="lazy">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Bar -->
  <section class="border-y border-slate-800 bg-slate-900/50">
    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center">
          <div class="text-3xl font-bold text-cyan-400">21,500+</div>
          <div class="text-gray-500">Аніме</div>
        </div>
        <div class="text-center">
          <div class="text-3xl font-bold text-purple-400">85,000+</div>
          <div class="text-gray-500">Персонажів</div>
        </div>
        <div class="text-center">
          <div class="text-3xl font-bold text-pink-400">12,000+</div>
          <div class="text-gray-500">Сейю</div>
        </div>
        <div class="text-center">
          <div class="text-3xl font-bold text-amber-400">350,000+</div>
          <div class="text-gray-500">Користувачів</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Trending Now -->
  <section class="py-16">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-3xl font-bold mb-2">Популярне зараз</h2>
          <p class="text-gray-500">Найпопулярніші аніме цього тижня</p>
        </div>
        <a href="{{ route('anime.index') }}" class="text-cyan-400 hover:text-cyan-300 font-medium flex items-center gap-2">
          Дивитись усі
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <!-- Card 1 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Frieren: Похоронний обряд</h4>
                <p class="text-xs text-gray-500 mb-3">Madhouse • Осінь 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 9.4</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">28 еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Ельфійська маг Фрірен подорожує світом після перемоги над Демонічним Королем, шукаючи сенс безсмертного існування.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">9.4</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-amber-500/90 text-white text-xs font-bold rounded-lg flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                #1
              </div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-slate-800/80 backdrop-blur-sm text-xs rounded-lg">Виходить</span>
              </div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Frieren: Похоронний обряд</h3>
          <p class="text-sm text-gray-500">ТБ, 2024</p>
        </a>
        <!-- Card 2 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Solo Leveling</h4>
                <p class="text-xs text-gray-500 mb-3">A-1 Pictures • Зима 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 9.2</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">12 еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Сон Джін-У, найслабший мисливець E-рангу, отримує здатність підвищувати рівень після таємничої події в підземеллі.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Solo+Leveling" alt="Solo Leveling" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">9.2</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-slate-700/90 text-white text-xs font-bold rounded-lg">#2</div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-slate-800/80 backdrop-blur-sm text-xs rounded-lg">Виходить</span>
              </div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Solo Leveling</h3>
          <p class="text-sm text-gray-500">ТБ, 2024</p>
        </a>
        <!-- Card 3 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Клинок, що знищує демонів S4</h4>
                <p class="text-xs text-gray-500 mb-3">ufotable • Весна 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 9.1</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">8 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Демони</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Історичний</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Танджіро та Стовпи Корпусу готуються до фінальної битви з Мудзаном. Арка тренування Хашира.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Demon+Slayer+S4" alt="Клинок" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">9.1</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-slate-700/90 text-white text-xs font-bold rounded-lg">#3</div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Клинок, що знищує демонів S4</h3>
          <p class="text-sm text-gray-500">ТБ, 2024</p>
        </a>
        <!-- Card 4 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Дзюцу Кайсен S2</h4>
                <p class="text-xs text-gray-500 mb-3">MAPPA • Літо 2023</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 8.9</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">23 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Фентезі</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Надприродне</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Минуле Годзьо та трагічний інцидент у Сібуї — найбільш епічний сезон серіалу про мисливців на прокляття.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Jujutsu+Kaisen" alt="Дзюцу Кайсен" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">8.9</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-slate-700/90 text-white text-xs font-bold rounded-lg">#4</div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Дзюцу Кайсен S2</h3>
          <p class="text-sm text-gray-500">ТБ, 2024</p>
        </a>
        <!-- Card 5 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Ван Піс</h4>
                <p class="text-xs text-gray-500 mb-3">Toei Animation • 1999</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 8.8</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">1095+ еп.</span>
                  <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Екшн</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Комедія</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Монкі Д. Луффі та команда Мугівар вирушають у пошуках легендарного скарбу на шляху до Короля Піратів.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=One+Piece" alt="Ван Піс" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">8.8</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-slate-700/90 text-white text-xs font-bold rounded-lg">#5</div>
              <div class="absolute bottom-3 left-3 right-3">
                <span class="px-2 py-1 bg-slate-800/80 backdrop-blur-sm text-xs rounded-lg">Виходить</span>
              </div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Ван Піс</h3>
          <p class="text-sm text-gray-500">ТБ, 1999</p>
        </a>
        <!-- Card 6 -->
        <a href="{{ route('anime.show', 'example-slug') }}" class="group card-hover">
          <div class="relative mb-3">
            <div class="absolute left-full top-0 ml-2 w-64 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
              <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4">
                <h4 class="font-semibold text-gray-200 mb-1">Oshi no Ko S2</h4>
                <p class="text-xs text-gray-500 mb-3">Doga Kobo • Літо 2024</p>
                <div class="flex items-center gap-3 mb-3 text-sm flex-wrap">
                  <span class="text-cyan-400 font-bold">★ 8.7</span><span class="text-gray-400">ТБ</span><span class="text-gray-400">13 еп.</span>
                  <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Драма</span>
                  <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Надприродне</span>
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Реінкарнація</span>
                </div>
                <p class="text-xs text-gray-400 line-clamp-3">Аква розслідує смерть своєї матері-ідолки, поринаючи в темну сторону японської індустрії розваг.</p>
              </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl">
              <img src="https://placehold.co/240x340/1e293b/94a3b8?text=Oshi+no+Ko" alt="Oshi no Ko" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              <div class="absolute top-3 left-3 px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg">8.7</div>
              <div class="absolute top-3 right-3 px-2 py-1 bg-slate-700/90 text-white text-xs font-bold rounded-lg">#6</div>
            </div>
            @include('main.components.anime-list-menu')
          </div>
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">Oshi no Ko S2</h3>
          <p class="text-sm text-gray-500">ТБ, 2024</p>
        </a>
      </div>
    </div>
  </section>

  <!-- New Releases & Schedule -->
  <section class="py-16 bg-slate-900/50">
    <div class="container mx-auto px-4">
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- New Episodes -->
        <div class="lg:col-span-2">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Нові епізоди</h2>
            <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі оновлення</a>
          </div>
          <div class="space-y-4">
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/100x140/1e293b/94a3b8?text=EP" alt="Anime" class="w-20 h-28 object-cover rounded-xl" loading="lazy">
              <div class="flex-grow">
                <div class="text-xs text-cyan-400 font-medium mb-1">Щойно вийшов</div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
                <p class="text-sm text-gray-500 mt-1">Епізод 28 - Назва епізоду</p>
                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                  <span>24 хв</span>
                  <span>SUB</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm text-gray-400">2 години тому</div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/100x140/1e293b/94a3b8?text=EP" alt="Anime" class="w-20 h-28 object-cover rounded-xl" loading="lazy">
              <div class="flex-grow">
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Solo Leveling</h3>
                <p class="text-sm text-gray-500 mt-1">Епізод 12 - Фінал сезону</p>
                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                  <span>24 хв</span>
                  <span>SUB</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm text-gray-400">5 годин тому</div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/100x140/1e293b/94a3b8?text=EP" alt="Anime" class="w-20 h-28 object-cover rounded-xl" loading="lazy">
              <div class="flex-grow">
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Дзюцу Кайсен</h3>
                <p class="text-sm text-gray-500 mt-1">Епізод 47 - Назва епізоду</p>
                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                  <span>24 хв</span>
                  <span>SUB</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm text-gray-400">1 день тому</div>
              </div>
            </a>
          </div>
        </div>
        <!-- Weekly Schedule -->
        <div>
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Розклад</h2>
            <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Повний</a>
          </div>
          <div class="bg-slate-800/50 rounded-2xl p-4">
            <div class="flex gap-2 mb-4 overflow-x-auto scrollbar-hide">
              <button class="px-4 py-2 bg-cyan-500 text-white rounded-lg text-sm font-medium whitespace-nowrap">Пн</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Вт</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Ср</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Чт</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Пт</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Сб</button>
              <button class="px-4 py-2 bg-slate-700 text-gray-400 hover:text-white rounded-lg text-sm font-medium whitespace-nowrap">Нд</button>
            </div>
            <div class="space-y-3">
              <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl hover:bg-slate-900 transition-colors">
                <div class="text-cyan-400 font-mono text-sm w-12">18:00</div>
                <div class="flex-grow">
                  <div class="font-medium text-sm text-gray-200">Solo Leveling</div>
                  <div class="text-xs text-gray-500">Ep. 13</div>
                </div>
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl hover:bg-slate-900 transition-colors">
                <div class="text-cyan-400 font-mono text-sm w-12">19:30</div>
                <div class="flex-grow">
                  <div class="font-medium text-sm text-gray-200">Frieren</div>
                  <div class="text-xs text-gray-500">Ep. 29</div>
                </div>
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl hover:bg-slate-900 transition-colors">
                <div class="text-cyan-400 font-mono text-sm w-12">22:00</div>
                <div class="flex-grow">
                  <div class="font-medium text-sm text-gray-200">Ван Піс</div>
                  <div class="text-xs text-gray-500">Ep. 1095</div>
                </div>
              </a>
              <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-3 p-3 bg-slate-900/50 rounded-xl hover:bg-slate-900 transition-colors">
                <div class="text-cyan-400 font-mono text-sm w-12">23:30</div>
                <div class="flex-grow">
                  <div class="font-medium text-sm text-gray-200">Mashle S2</div>
                  <div class="text-xs text-gray-500">Ep. 8</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Genres -->
  <section class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold mb-8">Жанри</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-red-500/20 to-red-600/10 border border-red-500/20 rounded-2xl hover:border-red-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">🔥</div>
          <div class="font-semibold text-gray-200 group-hover:text-red-400 transition-colors">Екшн</div>
          <div class="text-xs text-gray-500">3,420 аніме</div>
        </a>
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-pink-500/20 to-pink-600/10 border border-pink-500/20 rounded-2xl hover:border-pink-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">💕</div>
          <div class="font-semibold text-gray-200 group-hover:text-pink-400 transition-colors">Романтика</div>
          <div class="text-xs text-gray-500">2,810 аніме</div>
        </a>
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-purple-500/20 to-purple-600/10 border border-purple-500/20 rounded-2xl hover:border-purple-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">✨</div>
          <div class="font-semibold text-gray-200 group-hover:text-purple-400 transition-colors">Фентезі</div>
          <div class="text-xs text-gray-500">2,510 аніме</div>
        </a>
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 border border-yellow-500/20 rounded-2xl hover:border-yellow-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">😄</div>
          <div class="font-semibold text-gray-200 group-hover:text-yellow-400 transition-colors">Комедія</div>
          <div class="text-xs text-gray-500">4,230 аніме</div>
        </a>
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-blue-500/20 to-blue-600/10 border border-blue-500/20 rounded-2xl hover:border-blue-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">🎭</div>
          <div class="font-semibold text-gray-200 group-hover:text-blue-400 transition-colors">Драма</div>
          <div class="text-xs text-gray-500">2,150 аніме</div>
        </a>
        <a href="{{ route('anime.search') }}" class="group p-4 bg-gradient-to-br from-green-500/20 to-green-600/10 border border-green-500/20 rounded-2xl hover:border-green-500/40 transition-colors text-center">
          <div class="text-3xl mb-2">🗺️</div>
          <div class="font-semibold text-gray-200 group-hover:text-green-400 transition-colors">Пригоди</div>
          <div class="text-xs text-gray-500">2,890 аніме</div>
        </a>
      </div>
    </div>
  </section>

  <!-- Popular Characters -->
  <section class="py-16 bg-slate-900/50">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-3xl font-bold mb-2">Популярні персонажі</h2>
          <p class="text-gray-500">Найулюбленіші персонажі спільноти</p>
        </div>
        <a href="{{ route('characters.index') }}" class="text-cyan-400 hover:text-cyan-300 font-medium flex items-center gap-2">
          Усі персонажі
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Levi" alt="Леві" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Леві Аккерман</div>
              <div class="text-xs text-gray-400">Атака Титанів</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">125,430</span>
          </div>
        </a>
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Gojo" alt="Годзьо" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Сатору Годзьо</div>
              <div class="text-xs text-gray-400">Дзюцу Кайсен</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">118,250</span>
          </div>
        </a>
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Mikasa" alt="Мікаса" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Мікаса Аккерман</div>
              <div class="text-xs text-gray-400">Атака Титанів</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">98,120</span>
          </div>
        </a>
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Tanjiro" alt="Танджіро" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Танджіро Камадо</div>
              <div class="text-xs text-gray-400">Клинок</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">89,540</span>
          </div>
        </a>
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Anya" alt="Аня" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Аня Форджер</div>
              <div class="text-xs text-gray-400">Spy x Family</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">85,870</span>
          </div>
        </a>
        <a href="{{ route('characters.show', 'example-slug') }}" class="group card-hover text-center">
          <div class="relative overflow-hidden rounded-2xl mb-3">
            <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Zero+Two" alt="Zero Two" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3 text-left">
              <div class="font-semibold text-sm">Zero Two</div>
              <div class="text-xs text-gray-400">Darling in the Franxx</div>
            </div>
          </div>
          <div class="flex justify-center gap-1 text-amber-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-xs text-gray-400">82,340</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Studios Spotlight -->
  <section class="py-16">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">Топ студії</h2>
        <a href="{{ route('studios.index') }}" class="text-cyan-400 hover:text-cyan-300 font-medium">Усі студії</a>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
          <img src="https://placehold.co/120x60/1e293b/94a3b8?text=MAPPA" alt="MAPPA" class="h-12 object-contain mb-4 opacity-70 group-hover:opacity-100 transition-opacity" loading="lazy">
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">MAPPA</h3>
          <p class="text-sm text-gray-500">Jujutsu Kaisen, Attack on Titan Final</p>
        </a>
        <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
          <img src="https://placehold.co/120x60/1e293b/94a3b8?text=ufotable" alt="ufotable" class="h-12 object-contain mb-4 opacity-70 group-hover:opacity-100 transition-opacity" loading="lazy">
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">ufotable</h3>
          <p class="text-sm text-gray-500">Demon Slayer, Fate series</p>
        </a>
        <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
          <img src="https://placehold.co/120x60/1e293b/94a3b8?text=WIT" alt="WIT Studio" class="h-12 object-contain mb-4 opacity-70 group-hover:opacity-100 transition-opacity" loading="lazy">
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">WIT Studio</h3>
          <p class="text-sm text-gray-500">Spy x Family, Vinland Saga</p>
        </a>
        <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
          <img src="https://placehold.co/120x60/1e293b/94a3b8?text=Kyoto" alt="Kyoto Animation" class="h-12 object-contain mb-4 opacity-70 group-hover:opacity-100 transition-opacity" loading="lazy">
          <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Kyoto Animation</h3>
          <p class="text-sm text-gray-500">Violet Evergarden, K-On!</p>
        </a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
@include('main.components.list-menu-script')
@endpush
