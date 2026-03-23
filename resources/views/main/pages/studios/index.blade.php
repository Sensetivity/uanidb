@extends('main.layouts.app')

@section('title', 'Студії - УкрАніме')

@php $activeNav = 'studios'; @endphp

@section('content')
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Анімаційні студії</h1>
      <p class="text-gray-400">Каталог студій, що створюють аніме</p>
    </div>
  </div>

  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select onchange="window.location.href='{{ route('studios.index') }}?sort=' + this.value"
                class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
          <option value="anime_count" @selected($sortBy === 'anime_count')>За кількістю аніме</option>
          <option value="name" @selected($sortBy === 'name')>За алфавітом</option>
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">{{ number_format($studios->total()) }}</span> студій</span>
    </div>

    @if($studios->isEmpty())
      <x-empty-state message="Студій не знайдено" />
    @else
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($studios as $studio)
          <a href="{{ route('studios.show', $studio->slug) }}" class="group p-6 bg-slate-800/50 rounded-2xl hover:bg-slate-800 transition-colors" wire:navigate>
            <div class="flex items-center gap-4 mb-4">
              <div class="w-16 h-16 bg-slate-700 rounded-xl flex items-center justify-center overflow-hidden">
                @if($studio->logo_display_url)
                  <img src="{{ $studio->logo_display_url }}" alt="{{ $studio->name }}" class="w-12 object-contain opacity-70 group-hover:opacity-100 transition-opacity" loading="lazy">
                @else
                  <span class="text-gray-400 text-xl font-bold">{{ mb_substr($studio->name, 0, 1) }}</span>
                @endif
              </div>
              <div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">{{ $studio->name }}</h3>
                @if($studio->animes_count)
                  <p class="text-sm text-gray-500">{{ $studio->animes_count }} аніме</p>
                @endif
              </div>
            </div>
          </a>
        @endforeach
      </div>

      <div class="mt-10">
        {{ $studios->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
