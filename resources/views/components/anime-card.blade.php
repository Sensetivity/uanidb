@props(['anime', 'rank' => null, 'showRank' => false])
<a href="{{ route('anime.show', $anime->slug) }}" wire:navigate class="group card-hover block">
  <div class="relative mb-3">
    <div class="relative overflow-hidden rounded-2xl">
      <img
        src="{{ $anime->poster_url ?? 'https://placehold.co/240x340/1e293b/94a3b8?text=No+Image' }}"
        alt="{{ $anime->title }}"
        class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300"
        loading="lazy"
      >
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
      @if($anime->score)
        <x-score-badge :score="$anime->score" class="absolute top-3 left-3" />
      @endif
      @if($showRank && $rank)
        <span class="absolute top-3 right-3 px-2 py-1 bg-amber-500/90 text-white text-xs font-bold rounded-lg flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          #{{ $rank }}
        </span>
      @endif
      @if($anime->status)
        <div class="absolute bottom-3 left-3 right-3">
          <x-status-badge :status="$anime->status" class="px-2 py-1 bg-slate-800/80 backdrop-blur-sm rounded-lg" />
        </div>
      @endif
    </div>
  </div>
  <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-2">{{ $anime->title }}</h3>
  <p class="text-sm text-gray-500">{{ $anime->type->getLabel() }}@if($anime->aired_from), {{ $anime->aired_from->year }}@endif</p>
</a>
