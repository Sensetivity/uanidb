@extends('main.layouts.app')

@section('title', 'Сейю - УкрАніме')

@php $activeNav = 'people'; @endphp

@section('content')
  <!-- Page Header -->
  <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Сейю (Актори озвучення)</h1>
      <p class="text-gray-400">Понад 12,000 сейю з усього світу</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none">
          <option>За популярністю</option>
          <option>За кількістю ролей</option>
          <option>За алфавітом</option>
        </select>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Мова:</span>
        <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none">
          <option>Усі</option>
          <option>Японська</option>
          <option>Англійська</option>
          <option>Українська</option>
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">12,458</span> сейю</span>
    </div>

    <!-- Voice Actors Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
      <!-- VA Card 1 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Tanezaki" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-amber-500 text-white text-xs font-bold rounded">#1</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">156 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Танезакі Ацумі</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 2 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Kamiya" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-amber-500 text-white text-xs font-bold rounded">#2</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">312 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Камія Хіроші</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 3 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Kaji" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#3</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">245 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Кадзі Юкі</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 4 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Hanazawa" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#4</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">289 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Ханадзава Кана</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 5 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Miyano" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#5</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">278 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Міяно Мамору</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 6 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Ono" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#6</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">256 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Оно Дайсуке</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 7 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Sakura" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#7</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">198 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Сакура Аяне</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 8 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Hayami" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#8</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">187 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Хаямі Сорі</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 9 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Nakamura" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#9</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">234 ролі</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Накамура Юіті</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 10 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Suwabe" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#10</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">267 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Сувабе Джуніті</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 11 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Ishikawa" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#11</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">143 ролі</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Ішікава Юї</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
      <!-- VA Card 12 -->
      <a href="{{ route('people.show', 'example-slug') }}" class="group text-center">
        <div class="relative overflow-hidden rounded-2xl mb-3">
          <img src="https://placehold.co/200x200/1e293b/94a3b8?text=Matsuoka" alt="VA" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
          <div class="absolute top-2 right-2 px-2 py-0.5 bg-slate-700 text-white text-xs font-bold rounded">#12</div>
          <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">212 ролей</div>
        </div>
        <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Мацуока Йосіцугу</h3>
        <p class="text-sm text-gray-500">Японська</p>
      </a>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-10">
      <nav class="flex items-center gap-2">
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-500 text-white font-medium">1</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700">2</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700">3</button>
        <span class="text-gray-500 px-2">...</span>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700">623</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </nav>
    </div>
  </div>
@endsection

@section('footer')
  @include('main.components.footer-compact')
@endsection
