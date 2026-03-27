@extends('main.layouts.app')

@section('title', ($season ? $season->name : 'Сезони') . ' - УкрАніме')

@php $activeNav = 'seasons'; @endphp

@section('content')
  <div class="bg-gradient-to-r from-blue-500/10 via-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
          @if($season)
            <div class="flex items-center gap-3 mb-2">
              <span class="text-4xl">{{ $season->season_of_year->getEmoji() }}</span>
              <h1 class="text-4xl font-bold">{{ $season->name }}</h1>
            </div>
            <p class="text-gray-400">{{ $animes->count() }} аніме у сезоні</p>
          @else
            <h1 class="text-4xl font-bold">Сезонні аніме</h1>
          @endif
        </div>
        @if($seasons->isNotEmpty())
          <div>
            <select onchange="if(this.value) window.location.href = this.value"
                    class="py-2.5 px-4 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500">
              @foreach($seasons as $s)
                <option value="{{ route('seasons', ['year' => $s->year, 'season' => strtolower($s->season_of_year->name)]) }}"
                        @selected($season && $s->id === $season->id)>
                  {{ $s->name }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
      </div>
    </div>
  </div>

  <div class="container mx-auto px-4 py-8">
    @if($season)
      <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('seasons', ['year' => $season->year, 'season' => strtolower($season->season_of_year->name)]) }}"
           class="{{ !$typeFilter ? 'px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium text-white' : 'px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors' }}"
           wire:navigate>
          Усі ({{ $allAnimes->count() }})
        </a>
        @foreach(\App\Enums\AnimeTypeEnum::cases() as $type)
          @if($type !== \App\Enums\AnimeTypeEnum::UNKNOWN && ($typeCounts[$type->value] ?? 0) > 0)
            <a href="{{ route('seasons', ['year' => $season->year, 'season' => strtolower($season->season_of_year->name), 'type' => $type->slug()]) }}"
               class="{{ $typeFilter === $type->slug() ? 'px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium text-white' : 'px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-gray-400 hover:text-white transition-colors' }}"
               wire:navigate>
              {{ $type->getLabel() }} ({{ $typeCounts[$type->value] }})
            </a>
          @endif
        @endforeach
      </div>
    @endif

    @if($animes->isEmpty())
      <x-empty-state message="Аніме у цьому сезоні не знайдено" />
    @else
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
        @foreach($animes as $anime)
          <a href="{{ route('anime.show', $anime->slug) }}" class="group" wire:navigate>
            <div class="relative mb-2">
              <div class="relative overflow-hidden rounded-xl">
                <img src="{{ $anime->poster_url ?? 'https://placehold.co/180x250/1e293b/94a3b8?text=' . urlencode(mb_substr($anime->title, 0, 3)) }}"
                     alt="{{ $anime->title }}"
                     class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                @if($anime->score)
                  <div class="absolute top-2 right-2">
                    <x-score-badge :score="$anime->score" />
                  </div>
                @endif
              </div>
            </div>
            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">{{ $anime->title }}</h3>
            <p class="text-xs text-gray-500">
              {{ $anime->type?->getLabel() }}
              @if($anime->episode_count) | {{ $anime->episode_count }} еп. @endif
            </p>
          </a>
        @endforeach
      </div>
    @endif
  </div>
@endsection
