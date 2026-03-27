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
    <div class="flex flex-wrap items-center gap-4 mb-6 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select onchange="window.location.href='{{ route('studios.index') }}?sort=' + this.value"
                class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
          @foreach(\App\Enums\StudioSortEnum::cases() as $option)
            <option value="{{ $option->value }}" @selected($sort === $option)>{{ $option->getLabel() }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">{{ number_format($studios->total()) }}</span> студій</span>
    </div>

    @if($studios->isEmpty())
      <x-empty-state message="Студій не знайдено" />
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b border-slate-700/60 text-xs text-gray-500 uppercase tracking-wider">
              <th class="py-3 pr-2 w-10 text-center">#</th>
              <th class="py-3 px-3">Студія</th>
              <th class="py-3 px-3 w-14 text-center hidden sm:table-cell">Аніме</th>
              <th class="py-3 px-3 hidden lg:table-cell">Найпопулярніші</th>
              <th class="py-3 px-3 hidden xl:table-cell">Останні</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/40">
            @foreach($studios as $studio)
              @php $rank = ($studios->currentPage() - 1) * $studios->perPage() + $loop->iteration; @endphp
              <tr class="group hover:bg-slate-800/40 transition-colors">
                <td class="py-2.5 pr-2 text-center align-middle">
                  <span class="text-lg font-bold {{ $rank <= 3 ? 'text-amber-400' : 'text-gray-600' }}">{{ $rank }}</span>
                </td>
                <td class="py-2.5 px-3 align-middle">
                  <a href="{{ route('studios.show', $studio->slug) }}" class="flex items-center gap-3" wire:navigate>
                    <div class="w-10 h-10 bg-slate-700/60 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                      @if($studio->logo_display_url)
                        <img src="{{ $studio->logo_display_url }}" alt="{{ $studio->name }}" class="w-7 object-contain opacity-60 group-hover:opacity-100 transition-opacity" loading="lazy">
                      @else
                        <span class="text-gray-500 text-sm font-bold">{{ mb_substr($studio->name, 0, 1) }}</span>
                      @endif
                    </div>
                    <div>
                      <div class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">{{ $studio->name }}</div>
                      @if($studio->name_japanese)
                        <div class="text-xs text-gray-500">{{ $studio->name_japanese }}</div>
                      @endif
                    </div>
                  </a>
                </td>
                <td class="py-2.5 px-3 text-center align-middle hidden sm:table-cell">
                  <span class="text-sm {{ $studio->animes_count ? 'text-gray-300' : 'text-gray-600' }}">{{ $studio->animes_count ?: '—' }}</span>
                </td>
                <td class="py-2.5 px-3 align-middle hidden lg:table-cell">
                  @if($studio->popularAnimes->isNotEmpty())
                    @foreach($studio->popularAnimes as $anime)
                      <div class="text-sm leading-relaxed truncate max-w-[280px]">
                        <a href="{{ route('anime.show', $anime->slug) }}" class="text-gray-400 hover:text-cyan-400 transition-colors" wire:navigate>{{ $anime->title }}</a>
                        @if($anime->score)
                          <span class="text-cyan-500 text-xs ml-1">{{ number_format($anime->score, 2) }}</span>
                        @endif
                      </div>
                    @endforeach
                  @else
                    <span class="text-sm text-gray-600">—</span>
                  @endif
                </td>
                <td class="py-2.5 px-3 align-middle hidden xl:table-cell">
                  @if($studio->recentAnimes->isNotEmpty())
                    @foreach($studio->recentAnimes as $anime)
                      <div class="text-sm leading-relaxed truncate max-w-[280px]">
                        <a href="{{ route('anime.show', $anime->slug) }}" class="text-gray-400 hover:text-cyan-400 transition-colors" wire:navigate>{{ $anime->title }}</a>
                      </div>
                    @endforeach
                  @else
                    <span class="text-sm text-gray-600">—</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-10">
        {{ $studios->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
