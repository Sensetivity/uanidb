@php $activeNav = 'anime'; @endphp

@extends('main.layouts.app')

@section('title', 'Пошук аніме - УкрАніме')

@section('content')

  <!-- Search Header -->
  <div class="bg-gradient-to-b from-slate-900 to-slate-950 py-16">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold text-center mb-8">Пошук аніме</h1>
      <div class="max-w-3xl mx-auto">
        <div class="relative">
          <input type="text" placeholder="Введіть назву аніме, персонажа або студію..." value="Frieren" class="w-full py-4 px-6 pl-14 rounded-2xl bg-slate-800 border border-slate-700 text-lg text-gray-100 placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 absolute left-5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <button class="absolute right-3 top-1/2 -translate-y-1/2 px-6 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium hover:opacity-90 transition-opacity">
            Шукати
          </button>
        </div>
        <!-- Quick Filters -->
        <div class="flex flex-wrap justify-center gap-3 mt-6">
          <button class="px-4 py-2 bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 rounded-xl text-sm font-medium">Усе</button>
          <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-gray-400 hover:text-gray-200 transition-colors">Аніме</button>
          <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-gray-400 hover:text-gray-200 transition-colors">Манґа</button>
          <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-gray-400 hover:text-gray-200 transition-colors">Персонажі</button>
          <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-gray-400 hover:text-gray-200 transition-colors">Сейю</button>
          <button class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-gray-400 hover:text-gray-200 transition-colors">Студії</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Results -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <div class="text-gray-400">
        Знайдено <span class="text-white font-medium">24</span> результати для "<span class="text-cyan-400">Frieren</span>"
      </div>
      <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
        <option>За релевантністю</option>
        <option>За популярністю</option>
        <option>За рейтингом</option>
        <option>За датою</option>
      </select>
    </div>

    <!-- Results Sections -->
    <div class="space-y-10">
      <!-- Anime Results -->
      <section>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold">Аніме</h2>
          <a href="{{ route('anime.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі результати (3)</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-24 h-32 object-cover rounded-lg">
            <div class="flex-grow">
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
              <p class="text-sm text-gray-500 mt-1">ТБ | 2023 | 28 еп.</p>
              <div class="flex items-center gap-2 mt-2">
                <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">9.4</span>
                <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
              </div>
              <p class="text-sm text-gray-400 mt-2 line-clamp-2">Ельфійська чарівниця після перемоги над Королем Демонів...</p>
            </div>
          </a>
          <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Frieren+OVA" alt="Frieren OVA" loading="lazy" class="w-24 h-32 object-cover rounded-lg">
            <div class="flex-grow">
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Спеціальний випуск</h3>
              <p class="text-sm text-gray-500 mt-1">OVA | 2024 | 1 еп.</p>
              <div class="flex items-center gap-2 mt-2">
                <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">8.8</span>
                <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs">Завершено</span>
              </div>
              <p class="text-sm text-gray-400 mt-2 line-clamp-2">Бонусний епізод до серіалу Frieren...</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Character Results -->
      <section>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold">Персонажі</h2>
          <a href="{{ route('characters.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі результати (8)</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=F" alt="Frieren" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Фрірен</h3>
              <p class="text-sm text-gray-500">Frieren</p>
              <p class="text-xs text-gray-400 mt-1">42,150 уподобань</p>
            </div>
          </a>
          <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=Fe" alt="Fern" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Ферн</h3>
              <p class="text-sm text-gray-500">Fern</p>
              <p class="text-xs text-gray-400 mt-1">38,420 уподобань</p>
            </div>
          </a>
          <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=S" alt="Stark" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Штарк</h3>
              <p class="text-sm text-gray-500">Stark</p>
              <p class="text-xs text-gray-400 mt-1">32,180 уподобань</p>
            </div>
          </a>
          <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=H" alt="Himmel" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Гіммель</h3>
              <p class="text-sm text-gray-500">Himmel</p>
              <p class="text-xs text-gray-400 mt-1">28,750 уподобань</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Voice Actors Results -->
      <section>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold">Сейю</h2>
          <a href="{{ route('people.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі результати (4)</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <a href="{{ route('people.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=VA" alt="VA" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Танезакі Ацумі</h3>
              <p class="text-sm text-gray-500">Голос Фрірен</p>
              <p class="text-xs text-gray-400 mt-1">156 ролей</p>
            </div>
          </a>
          <a href="{{ route('people.show', 'example-slug') }}" class="flex gap-3 p-3 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/80x80/1e293b/94a3b8?text=VA" alt="VA" loading="lazy" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Ітікава Маріа</h3>
              <p class="text-sm text-gray-500">Голос Ферн</p>
              <p class="text-xs text-gray-400 mt-1">42 ролі</p>
            </div>
          </a>
        </div>
      </section>

      <!-- Manga Results -->
      <section>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold">Манґа</h2>
          <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі результати (2)</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <a href="#" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
            <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Manga" alt="Manga" loading="lazy" class="w-24 h-32 object-cover rounded-lg">
            <div class="flex-grow">
              <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Beyond Journey's End</h3>
              <p class="text-sm text-gray-500 mt-1">Манґа | 2020 | 13+ томів</p>
              <div class="flex items-center gap-2 mt-2">
                <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">9.2</span>
                <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-xs">Виходить</span>
              </div>
              <p class="text-sm text-gray-400 mt-2 line-clamp-2">Оригінальна манґа-джерело для аніме...</p>
            </div>
          </a>
        </div>
      </section>
    </div>
  </div>

  <!-- Footer -->
@endsection
