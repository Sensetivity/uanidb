@extends('main.layouts.app')

@section('title', 'Персонажі - УкрАніме')

@php $activeNav = 'characters'; @endphp

@section('content')
  <!-- Page Header -->
  <div class="bg-gradient-to-r from-pink-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Персонажі аніме</h1>
      <p class="text-gray-400">Понад 85,000 персонажів з усіх аніме та манґи</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
          <option>За популярністю</option>
          <option>За уподобаннями</option>
          <option>За алфавітом (А-Я)</option>
          <option>За алфавітом (Я-А)</option>
        </select>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Стать:</span>
        <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
          <option>Усі</option>
          <option>Чоловіча</option>
          <option>Жіноча</option>
          <option>Інша</option>
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">85,432</span> персонажів</span>
    </div>

    <!-- Character Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
      <!-- Character Card 1 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Levi" alt="Леві" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-amber-500 text-white text-xs font-bold rounded">#1</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>125,430</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Леві Аккерман</h3>
        <p class="text-sm text-gray-500">Атака Титанів</p>
      </a>
      <!-- Character Card 2 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Gojo" alt="Годзьо" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-amber-500 text-white text-xs font-bold rounded">#2</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>118,250</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Сатору Годзьо</h3>
        <p class="text-sm text-gray-500">Дзюцу Кайсен</p>
      </a>
      <!-- Character Card 3 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Mikasa" alt="Мікаса" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#3</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>98,120</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Мікаса Аккерман</h3>
        <p class="text-sm text-gray-500">Атака Титанів</p>
      </a>
      <!-- Character Card 4 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Tanjiro" alt="Танджіро" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#4</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>89,540</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Танджіро Камадо</h3>
        <p class="text-sm text-gray-500">Клинок</p>
      </a>
      <!-- Character Card 5 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Anya" alt="Аня" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#5</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>85,870</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Аня Форджер</h3>
        <p class="text-sm text-gray-500">Spy x Family</p>
      </a>
      <!-- Character Card 6 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Zero+Two" alt="Zero Two" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#6</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>82,340</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Zero Two</h3>
        <p class="text-sm text-gray-500">Darling in the Franxx</p>
      </a>
      <!-- Character Card 7 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Eren" alt="Ерен" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#7</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>78,920</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Ерен Єгер</h3>
        <p class="text-sm text-gray-500">Атака Титанів</p>
      </a>
      <!-- Character Card 8 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Nezuko" alt="Незуко" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#8</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>75,640</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Незуко Камадо</h3>
        <p class="text-sm text-gray-500">Клинок</p>
      </a>
      <!-- Character Card 9 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Rem" alt="Рем" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#9</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>72,350</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Рем</h3>
        <p class="text-sm text-gray-500">Re:Zero</p>
      </a>
      <!-- Character Card 10 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Luffy" alt="Луффі" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#10</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>69,870</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Монкі Д. Луффі</h3>
        <p class="text-sm text-gray-500">Ван Піс</p>
      </a>
      <!-- Character Card 11 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Marin" alt="Марін" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#11</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>65,420</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Марін Кітагава</h3>
        <p class="text-sm text-gray-500">My Dress-Up Darling</p>
      </a>
      <!-- Character Card 12 -->
      <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Frieren" alt="Фрірен" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#12</div>
          <div class="absolute bottom-2 left-2 right-2">
            <div class="flex items-center justify-center gap-1 text-pink-400 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              <span>42,150</span>
            </div>
          </div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Фрірен</h3>
        <p class="text-sm text-gray-500">Frieren</p>
      </a>
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
        <span class="text-gray-500 px-2">...</span>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700 transition-colors">4272</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </nav>
    </div>
  </div>
@endsection
