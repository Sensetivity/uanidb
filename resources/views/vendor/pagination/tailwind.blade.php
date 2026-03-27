@if ($paginator->hasPages())
  @php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();

    $pages = collect();
    $pages->push(1);
    for ($i = max(2, $currentPage - 1); $i <= min($lastPage - 1, $currentPage + 1); $i++) {
        $pages->push($i);
    }
    if ($lastPage > 1) {
        $pages->push($lastPage);
    }
    $pages = $pages->unique()->sort();
  @endphp

  <nav role="navigation" aria-label="Навігація сторінками" class="flex flex-col items-center gap-3">
    <div class="flex items-center gap-2">
      @if ($paginator->onFirstPage())
        <span class="h-10 px-4 flex items-center justify-center rounded-lg bg-slate-800/50 text-gray-600 cursor-not-allowed text-sm">
          <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
          Назад
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" wire:navigate
           class="h-10 px-4 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white transition-colors text-sm">
          <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
          Назад
        </a>
      @endif

      @php $prevPage = null; @endphp
      @foreach ($pages as $page)
        @if ($prevPage && $page - $prevPage > 1)
          <span class="w-10 h-10 flex items-center justify-center text-gray-500">...</span>
        @endif

        @if ($page == $currentPage)
          <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-500 text-white text-base font-semibold">{{ $page }}</span>
        @else
          <a href="{{ $paginator->url($page) }}" wire:navigate
             class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-800 text-gray-300 text-base hover:bg-slate-700 hover:text-white transition-colors">
            {{ $page }}
          </a>
        @endif
        @php $prevPage = $page; @endphp
      @endforeach

      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" wire:navigate
           class="h-10 px-4 flex items-center justify-center rounded-lg bg-slate-800 text-gray-400 hover:bg-slate-700 hover:text-white transition-colors text-sm">
          Далі
          <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
      @else
        <span class="h-10 px-4 flex items-center justify-center rounded-lg bg-slate-800/50 text-gray-600 cursor-not-allowed text-sm">
          Далі
          <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </span>
      @endif
    </div>

    <p class="text-sm text-gray-500">
      {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} з {{ number_format($paginator->total()) }}
    </p>
  </nav>
@endif
