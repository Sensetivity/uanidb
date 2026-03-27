<a href="{{ route('anime.show', $anime->slug) }}" wire:navigate
   class="flex gap-4 bg-slate-900/50 rounded-xl p-4 hover:bg-slate-800/50 transition-colors group block">
  <div class="relative flex-shrink-0 w-24 sm:w-32">
    <img src="{{ $anime->poster_url ?? 'https://placehold.co/240x340/1e293b/94a3b8?text=No+Image' }}"
         alt="{{ $anime->title }}"
         class="w-full aspect-[3/4] object-cover rounded-lg"
         loading="lazy">
    @if($anime->score)
      <x-score-badge :score="$anime->score" class="absolute top-1 left-1" />
    @endif
  </div>
  <div class="flex-grow min-w-0">
    <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
      <h3 class="font-semibold text-lg text-gray-200 group-hover:text-cyan-400 transition-colors">{{ $anime->title }}</h3>
      <div class="flex gap-2 flex-shrink-0">
        <span class="px-2 py-0.5 bg-slate-700 text-xs text-gray-300 rounded">{{ $anime->type->getLabel() }}</span>
        @if($anime->status)
          <x-status-badge :status="$anime->status" class="px-2 py-0.5" />
        @endif
      </div>
    </div>
    @if($anime->synopsis_uk ?? $anime->synopsis)
      <p class="text-sm text-gray-400 mb-3 line-clamp-2">{{ $anime->synopsis_uk ?? $anime->synopsis }}</p>
    @endif
    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
      @if($anime->episode_count)
        <span>{{ $anime->episode_count }} еп.</span>
      @endif
      @if($anime->aired_from)
        <span>{{ $anime->aired_from->year }}</span>
      @endif
      @if($anime->studios->isNotEmpty())
        <span>{{ $anime->studios->pluck('name')->join(', ') }}</span>
      @endif
    </div>
    @if($anime->genres->isNotEmpty())
      <div class="flex flex-wrap gap-1.5 mt-3">
        @foreach($anime->genres->take(6) as $genreItem)
          <span class="px-2 py-0.5 bg-slate-800 text-xs text-gray-400 rounded">{{ $genreItem->name }}</span>
        @endforeach
      </div>
    @endif
  </div>
</a>
