@extends('main.layouts.app')

@section('title', 'Сейю - УкрАніме')

@php $activeNav = 'people'; @endphp

@section('content')
  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Left Sidebar -->
      <div class="lg:w-80 flex-shrink-0">
        <img src="https://placehold.co/320x400/1e293b/94a3b8?text=VA+Photo" alt="Танезакі Ацумі" class="w-full rounded-2xl shadow-2xl mb-6">
        <button class="w-full py-3 bg-gradient-to-r from-pink-500 to-red-500 rounded-xl font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
          </svg>
          Додати до улюблених
        </button>
        <div class="bg-slate-800/50 rounded-2xl p-5 mb-6">
          <h3 class="font-semibold mb-4">Статистика</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Популярність</span><span class="text-amber-400">#24</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Уподобань</span><span class="text-pink-400">28,540</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Ролей</span><span>156</span></div>
          </div>
        </div>
        <div class="bg-slate-800/50 rounded-2xl p-5">
          <h3 class="font-semibold mb-4">Інформація</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Ім'я (укр)</span><span>Танезакі Ацумі</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Ім'я (яп)</span><span>種崎 敦美</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Дата народження</span><span>27 вересня 1988</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Місце</span><span>Осака, Японія</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Агенція</span><span>Toyama Office</span></div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="flex-grow">
        <h1 class="text-4xl font-bold mb-2">Танезакі Ацумі</h1>
        <div class="text-xl text-gray-400 mb-6">Tanezaki Atsumi / 種崎 敦美</div>

        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-4">Біографія</h2>
          <p class="text-gray-300 leading-relaxed">Танезакі Ацумі - японська сейю, народилася 27 вересня 1988 року в Осаці. Відома своїми ролями Фрірен у "Frieren: Beyond Journey's End", Аня Форджер у "Spy x Family", та багатьма іншими популярними персонажами.</p>
        </section>

        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-6">Популярні ролі</h2>
          <div class="grid sm:grid-cols-2 gap-4">
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x100/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-20 h-24 object-cover rounded-lg" loading="lazy">
              <div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Фрірен</h3>
                <p class="text-sm text-gray-500">Frieren: Похоронний обряд</p>
                <span class="text-xs text-pink-400">Головна роль</span>
              </div>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x100/1e293b/94a3b8?text=Anya" alt="Anya" class="w-20 h-24 object-cover rounded-lg" loading="lazy">
              <div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Аня Форджер</h3>
                <p class="text-sm text-gray-500">Spy x Family</p>
                <span class="text-xs text-pink-400">Головна роль</span>
              </div>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x100/1e293b/94a3b8?text=Char" alt="Character" class="w-20 h-24 object-cover rounded-lg" loading="lazy">
              <div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Віві</h3>
                <p class="text-sm text-gray-500">Vivy: Fluorite Eye's Song</p>
                <span class="text-xs text-pink-400">Головна роль</span>
              </div>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x100/1e293b/94a3b8?text=Char" alt="Character" class="w-20 h-24 object-cover rounded-lg" loading="lazy">
              <div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Еурека</h3>
                <p class="text-sm text-gray-500">Eureka Seven</p>
                <span class="text-xs text-purple-400">Другорядна роль</span>
              </div>
            </a>
          </div>
          <button class="mt-4 text-cyan-400 hover:text-cyan-300 font-medium">Показати всі 156 ролей</button>
        </section>

        <section>
          <h2 class="text-2xl font-bold mb-6">Фільмографія</h2>
          <div class="space-y-3">
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/60x80/1e293b/94a3b8?text=Anime" alt="Anime" class="w-14 h-18 object-cover rounded-lg" loading="lazy">
              <div class="flex-grow">
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
                <p class="text-sm text-gray-500">Фрірен - Головна роль</p>
              </div>
              <span class="text-sm text-gray-500">2023</span>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/60x80/1e293b/94a3b8?text=Anime" alt="Anime" class="w-14 h-18 object-cover rounded-lg" loading="lazy">
              <div class="flex-grow">
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Spy x Family S2</h3>
                <p class="text-sm text-gray-500">Аня Форджер - Головна роль</p>
              </div>
              <span class="text-sm text-gray-500">2023</span>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/60x80/1e293b/94a3b8?text=Anime" alt="Anime" class="w-14 h-18 object-cover rounded-lg" loading="lazy">
              <div class="flex-grow">
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Spy x Family</h3>
                <p class="text-sm text-gray-500">Аня Форджер - Головна роль</p>
              </div>
              <span class="text-sm text-gray-500">2022</span>
            </a>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @include('main.components.footer-compact')
@endsection
