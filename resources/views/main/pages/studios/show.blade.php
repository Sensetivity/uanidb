@extends('main.layouts.app')

@section('title', 'Студія - УкрАніме')

@php $activeNav = 'studios'; @endphp

@section('content')
  <!-- Studio Header -->
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row items-center gap-8">
        <div class="w-40 h-40 bg-slate-800 rounded-2xl flex items-center justify-center">
          <img src="https://placehold.co/160x80/1e293b/94a3b8?text=MAPPA" alt="MAPPA Logo" class="w-32 object-contain">
        </div>
        <div>
          <h1 class="text-4xl font-bold mb-2">MAPPA</h1>
          <p class="text-gray-400 mb-4">Японська анімаційна студія, заснована в 2011 році</p>
          <div class="flex flex-wrap gap-4 text-sm">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
              </svg>
              <span>87 аніме</span>
            </div>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>Токіо, Японія</span>
            </div>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>Засновано: 2011</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- About -->
    <section class="mb-12">
      <h2 class="text-2xl font-bold mb-4">Про студію</h2>
      <p class="text-gray-300 leading-relaxed">MAPPA - це японська анімаційна студія, заснована в 2011 році Масао Маруямою після його відходу з Madhouse. Студія відома такими роботами як "Атака Титанів: Фінальний сезон", "Дзюцу Кайсен", "Людина-бензопила" та багатьма іншими популярними аніме. MAPPA швидко стала однією з найвідоміших анімаційних студій в індустрії завдяки високій якості анімації та амбітним проєктам.</p>
    </section>

    <!-- Popular Anime -->
    <section class="mb-12">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Популярні роботи</h2>
        <a href="{{ route('anime.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі роботи (87)</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=JJK" alt="Jujutsu Kaisen" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.9</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Дзюцу Кайсен</h3>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=AoT" alt="Attack on Titan" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">9.0</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Атака Титанів: Фінал</h3>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=CSM" alt="Chainsaw Man" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.6</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Людина-бензопила</h3>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Vinland" alt="Vinland Saga" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.8</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Вінланд Сага S2</h3>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Banana" alt="Banana Fish" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.5</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Banana Fish</h3>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
          <div class="relative overflow-hidden rounded-xl mb-2">
            <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Zombieland" alt="Zombieland Saga" class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">8.0</div>
          </div>
          <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">Zombieland Saga</h3>
        </a>
      </div>
    </section>

    <!-- All Anime List -->
    <section>
      <h2 class="text-2xl font-bold mb-6">Усі роботи</h2>
      <div class="space-y-3">
        <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
          <img src="https://placehold.co/60x80/1e293b/94a3b8?text=JJK" alt="Anime" class="w-14 h-18 object-cover rounded-lg">
          <div class="flex-grow">
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Дзюцу Кайсен S2</h3>
            <p class="text-sm text-gray-500">ТБ | 23 еп.</p>
          </div>
          <div class="text-right">
            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs font-medium">8.9</span>
            <p class="text-sm text-gray-500 mt-1">2023</p>
          </div>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
          <img src="https://placehold.co/60x80/1e293b/94a3b8?text=AoT" alt="Anime" class="w-14 h-18 object-cover rounded-lg">
          <div class="flex-grow">
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Атака Титанів: Фінальний сезон - Частина 3</h3>
            <p class="text-sm text-gray-500">ТБ | 16 еп.</p>
          </div>
          <div class="text-right">
            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs font-medium">9.0</span>
            <p class="text-sm text-gray-500 mt-1">2023</p>
          </div>
        </a>
        <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
          <img src="https://placehold.co/60x80/1e293b/94a3b8?text=CSM" alt="Anime" class="w-14 h-18 object-cover rounded-lg">
          <div class="flex-grow">
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Людина-бензопила</h3>
            <p class="text-sm text-gray-500">ТБ | 12 еп.</p>
          </div>
          <div class="text-right">
            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs font-medium">8.6</span>
            <p class="text-sm text-gray-500 mt-1">2022</p>
          </div>
        </a>
      </div>
      <button class="mt-4 text-cyan-400 hover:text-cyan-300 font-medium">Показати всі 87 аніме</button>
    </section>
  </div>
@endsection

@section('footer')
  @include('main.components.footer-compact')
@endsection
