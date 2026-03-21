@props(['items'])
<div class="bg-slate-900/50 border-b border-slate-800">
  <div class="container mx-auto px-4 py-3">
    <div class="flex items-center gap-2 text-sm">
      @foreach($items as $item)
        @if(!$loop->last)
          <a href="{{ $item['url'] }}" wire:navigate class="text-gray-500 hover:text-cyan-400 transition-colors">{{ $item['name'] }}</a>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        @else
          <span class="text-gray-300">{{ $item['name'] }}</span>
        @endif
      @endforeach
    </div>
  </div>
</div>
