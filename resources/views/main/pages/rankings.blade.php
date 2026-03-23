@extends('main.layouts.app')

@section('title', $category->getLabel() . ' - Рейтинги - УкрАніме')

@php $activeNav = 'rankings'; @endphp

@section('content')
  <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Рейтинги аніме</h1>
      <p class="text-gray-400">Найкращі аніме за оцінками спільноти</p>
    </div>
  </div>

  <div class="container mx-auto px-4 py-8">
    {{-- Category Tabs --}}
    <div class="flex flex-wrap gap-3 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      @foreach(\App\Enums\RankingCategoryEnum::cases() as $cat)
        <a href="{{ route('rankings', ['category' => $cat->value]) }}"
           class="{{ $cat === $category
             ? 'px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium text-white'
             : 'px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-medium text-gray-400 hover:text-white transition-colors' }}"
           wire:navigate>
          {{ $cat->getLabel() }}
        </a>
      @endforeach
    </div>

    @if($animes->isEmpty())
      <x-empty-state message="Аніме не знайдено" />
    @else
      <div class="space-y-4">
        @foreach($animes as $anime)
          @php
            $rank = ($animes->currentPage() - 1) * $animes->perPage() + $loop->iteration;
            $isTop3 = $rank <= 3;
          @endphp
          <a href="{{ route('anime.show', $anime->slug) }}"
             class="flex items-center gap-4 p-4 {{ $rank === 1 ? 'bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/20' : 'bg-slate-800/50' }} rounded-2xl hover:bg-slate-800 transition-colors"
             wire:navigate>
            <div class="w-12 h-12 flex items-center justify-center text-2xl font-bold {{ $rank === 1 ? 'bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent' : 'text-gray-400' }}">
              {{ $rank }}
            </div>
            <img src="{{ $anime->poster_url ?? 'https://placehold.co/80x110/1e293b/94a3b8?text=' . urlencode(mb_substr($anime->title, 0, 3)) }}"
                 alt="{{ $anime->title }}"
                 class="w-16 h-22 object-cover rounded-lg flex-shrink-0"
                 loading="lazy">
            <div class="flex-grow min-w-0">
              <h3 class="font-semibold text-lg text-gray-200 truncate">{{ $anime->title }}</h3>
              <p class="text-sm text-gray-500">
                {{ $anime->type?->getLabel() }}
                @if($anime->episode_count) | {{ $anime->episode_count }} еп. @endif
                @if($anime->studios->isNotEmpty()) | {{ $anime->studios->first()?->name }} @endif
              </p>
              @if($anime->genres->isNotEmpty())
                <div class="flex gap-2 mt-1">
                  @foreach($anime->genres->take(3) as $genre)
                    <span class="px-2 py-0.5 bg-slate-800 rounded text-xs text-gray-400">{{ $genre->name }}</span>
                  @endforeach
                </div>
              @endif
            </div>
            @if($anime->score)
              <div class="text-right flex-shrink-0">
                <div class="text-3xl font-bold {{ $isTop3 ? 'text-amber-400' : 'text-cyan-400' }}">{{ number_format($anime->score, 1) }}</div>
              </div>
            @endif
          </a>
        @endforeach
      </div>

      <div class="mt-8">
        {{ $animes->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
