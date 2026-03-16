@extends('main.layouts.app')

@section('title', 'Студії - УкрАніме')

@php $activeNav = 'studios'; @endphp

@section('content')
  <!-- Page Header -->
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Анімаційні студії</h1>
      <p class="text-gray-400">Понад 800 студій, що створюють аніме</p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none">
          <option>За кількістю аніме</option>
          <option>За популярністю</option>
          <option>За алфавітом</option>
          <option>За середнім рейтингом</option>
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">847</span> студій</span>
    </div>

    <!-- Studios Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <!-- Studio Card 1 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=MAPPA" alt="MAPPA" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">MAPPA</h3>
            <p class="text-sm text-gray-500">87 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Jujutsu Kaisen, Attack on Titan Final, Chainsaw Man</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.4</span>
        </div>
      </a>
      <!-- Studio Card 2 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=ufotable" alt="ufotable" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">ufotable</h3>
            <p class="text-sm text-gray-500">56 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Demon Slayer, Fate series, Tales of Zestiria</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.6</span>
        </div>
      </a>
      <!-- Studio Card 3 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=WIT" alt="WIT" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">WIT Studio</h3>
            <p class="text-sm text-gray-500">42 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Spy x Family, Vinland Saga, Attack on Titan S1-3</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.5</span>
        </div>
      </a>
      <!-- Studio Card 4 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=Kyoto" alt="Kyoto Animation" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Kyoto Animation</h3>
            <p class="text-sm text-gray-500">78 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Violet Evergarden, K-On!, Clannad, Haruhi</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.3</span>
        </div>
      </a>
      <!-- Studio Card 5 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=Bones" alt="Bones" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Bones</h3>
            <p class="text-sm text-gray-500">124 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">My Hero Academia, Mob Psycho 100, FMA</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.2</span>
        </div>
      </a>
      <!-- Studio Card 6 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=Madhouse" alt="Madhouse" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Madhouse</h3>
            <p class="text-sm text-gray-500">256 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Frieren, One Punch Man, Death Note, Hunter x Hunter</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 8.1</span>
        </div>
      </a>
      <!-- Studio Card 7 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=A-1" alt="A-1 Pictures" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">A-1 Pictures</h3>
            <p class="text-sm text-gray-500">198 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">Sword Art Online, Kaguya-sama, 86</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 7.9</span>
        </div>
      </a>
      <!-- Studio Card 8 -->
      <a href="{{ route('studios.show', 'example-slug') }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center">
            <img src="https://placehold.co/64x32/1e293b/94a3b8?text=Toei" alt="Toei Animation" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity">
          </div>
          <div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Toei Animation</h3>
            <p class="text-sm text-gray-500">534 аніме</p>
          </div>
        </div>
        <p class="text-sm text-gray-400 line-clamp-2">One Piece, Dragon Ball, Sailor Moon</p>
        <div class="mt-3 flex items-center gap-2">
          <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Середній: 7.8</span>
        </div>
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
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 hover:bg-slate-700">43</button>
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
