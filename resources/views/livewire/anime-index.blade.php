<div>
  {{-- Page Header --}}
  <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Каталог аніме</h1>
      <p class="text-gray-400">Знайдіть та досліджуйте аніме</p>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

      {{-- Filters Sidebar --}}
      <div class="w-full lg:w-72 flex-shrink-0" x-data="{ open: false }">
        {{-- Mobile toggle --}}
        <button @click="open = !open"
                class="lg:hidden w-full flex items-center justify-between py-3 px-5 mb-4 bg-slate-900/50 rounded-2xl text-gray-200 font-semibold">
          <span>Фільтри</span>
          <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div x-show="open" x-cloak class="lg:!block">
          <div class="bg-slate-900/50 rounded-2xl p-5 sticky top-24">
            {{-- Header + Reset --}}
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-lg font-semibold">Фільтри</h3>
              @if($hasFilters)
                <button wire:click="resetFilters" class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">Скинути</button>
              @endif
            </div>

            {{-- Search --}}
            <div class="mb-6">
              <label class="block text-sm text-gray-400 mb-2">Пошук</label>
              <input wire:model.live.debounce.300ms="search"
                     type="text"
                     placeholder="Назва аніме..."
                     class="w-full py-2.5 px-4 rounded-xl bg-slate-800 border border-slate-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:border-cyan-500 transition-all">
            </div>

            {{-- Type --}}
            <div class="mb-6">
              <label class="block text-sm text-gray-400 mb-3">Тип</label>
              <div class="flex flex-wrap gap-2">
                @foreach($typeOptions as $typeEnum)
                  @php $isActive = str_contains($type, $typeEnum->slug()); @endphp
                  <button wire:click="toggleType('{{ $typeEnum->slug() }}')"
                          class="px-3 py-1.5 rounded-lg text-sm transition-colors border {{ $isActive ? 'bg-cyan-500/20 text-cyan-400 border-cyan-500/30 font-medium' : 'bg-slate-800 border-slate-700 text-gray-400 hover:text-gray-200 hover:border-slate-600' }}">
                    {{ $typeEnum->getLabel() }}
                  </button>
                @endforeach
              </div>
            </div>

            {{-- Status --}}
            <div class="mb-6">
              <label class="block text-sm text-gray-400 mb-3">Статус</label>
              <div class="space-y-2">
                @foreach($statusOptions as $statusEnum)
                  @php $isActive = str_contains($status, $statusEnum->slug()); @endphp
                  <label wire:click.prevent="toggleStatus('{{ $statusEnum->slug() }}')"
                         class="flex items-center gap-3 cursor-pointer group">
                    <span class="w-4 h-4 rounded border flex items-center justify-center {{ $isActive ? 'bg-cyan-500 border-cyan-500' : 'border-slate-600 bg-slate-800' }}">
                      @if($isActive)
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      @endif
                    </span>
                    <span class="{{ $isActive ? 'text-gray-100' : 'text-gray-300 group-hover:text-gray-100' }} transition-colors">{{ $statusEnum->getLabel() }}</span>
                  </label>
                @endforeach
              </div>
            </div>

            {{-- Genres --}}
            <div class="mb-6" x-data="{ expanded: false }">
              <label class="block text-sm text-gray-400 mb-3">Жанри</label>
              <div class="flex flex-wrap gap-2">
                @foreach($genres as $genreItem)
                  @php
                    $genreSlug = strtolower($genreItem->mal_title);
                    $isActive = in_array($genreSlug, array_filter(explode(',', $genre)));
                  @endphp
                  <button wire:click="toggleGenre('{{ $genreSlug }}')"
                          x-show="expanded || {{ $loop->index }} < 12"
                          class="px-3 py-1.5 rounded-lg text-sm transition-colors border {{ $isActive ? 'bg-cyan-500/20 text-cyan-400 border-cyan-500/30 font-medium' : 'bg-slate-800 border-slate-700 text-gray-400 hover:text-gray-200 hover:border-slate-600' }}">
                    {{ $genreItem->name }}
                  </button>
                @endforeach
              </div>
              @if($genres->count() > 12)
                <button @click="expanded = !expanded" class="text-sm text-cyan-400 hover:text-cyan-300 mt-3 transition-colors">
                  <span x-text="expanded ? 'Згорнути' : 'Усі жанри...'"></span>
                </button>
              @endif
            </div>

            {{-- Year --}}
            <div class="mb-6">
              <label class="block text-sm text-gray-400 mb-3">Рік</label>
              <div class="flex gap-3">
                <select wire:model.live="yearFrom"
                        class="flex-1 py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
                  <option value="">Від</option>
                  @for($y = date('Y') + 1; $y >= 1960; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                  @endfor
                </select>
                <select wire:model.live="yearTo"
                        class="flex-1 py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
                  <option value="">До</option>
                  @for($y = date('Y') + 1; $y >= 1960; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                  @endfor
                </select>
              </div>
            </div>

            {{-- Min Score --}}
            <div class="mb-6">
              <label class="block text-sm text-gray-400 mb-3">Мінімальний рейтинг</label>
              <select wire:model.live="score"
                      class="w-full py-2.5 px-3 rounded-xl bg-slate-800 border border-slate-700 text-gray-300 focus:outline-none focus:border-cyan-500 transition-all">
                <option value="">Будь-який</option>
                @foreach([9, 8, 7, 6, 5, 4, 3, 2, 1] as $s)
                  <option value="{{ $s }}">{{ $s }}+</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      {{-- Results Area --}}
      <div class="flex-grow min-w-0">
        {{-- Sort & View Options --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
          <span class="text-gray-500">Знайдено: <span class="text-gray-200 font-medium">{{ number_format($animes->total()) }}</span> аніме</span>
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-500">Сортувати:</span>
              <select wire:model.live="sort"
                      class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
                @foreach($sortOptions as $option)
                  <option value="{{ $option->value }}" @selected($sortEnum === $option)>{{ $option->getLabel() }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex items-center gap-1">
              <button wire:click="$set('view', 'grid')"
                      class="p-2 rounded-lg transition-colors {{ $view === 'grid' ? 'bg-cyan-500/20 text-cyan-400' : 'bg-slate-800 text-gray-400 hover:text-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
              </button>
              <button wire:click="$set('view', 'list')"
                      class="p-2 rounded-lg transition-colors {{ $view === 'list' ? 'bg-cyan-500/20 text-cyan-400' : 'bg-slate-800 text-gray-400 hover:text-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        {{-- Skeleton Loading --}}
        @if($view === 'grid')
          <div wire:loading.grid class="grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
            @for($i = 0; $i < 10; $i++)
              <div class="animate-pulse">
                <div class="rounded-2xl bg-slate-800 aspect-[3/4] mb-3"></div>
                <div class="h-4 bg-slate-800 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-slate-800 rounded w-1/2"></div>
              </div>
            @endfor
          </div>
        @else
          <div wire:loading.block class="space-y-4">
            @for($i = 0; $i < 5; $i++)
              <div class="animate-pulse flex gap-4 bg-slate-900/50 rounded-xl p-4">
                <div class="flex-shrink-0 w-24 sm:w-32 aspect-[3/4] bg-slate-800 rounded-lg"></div>
                <div class="flex-grow space-y-3 py-1">
                  <div class="h-5 bg-slate-800 rounded w-1/3"></div>
                  <div class="h-3 bg-slate-800 rounded w-full"></div>
                  <div class="h-3 bg-slate-800 rounded w-2/3"></div>
                  <div class="flex gap-2 pt-1">
                    <div class="h-5 bg-slate-800 rounded w-12"></div>
                    <div class="h-5 bg-slate-800 rounded w-16"></div>
                    <div class="h-5 bg-slate-800 rounded w-10"></div>
                  </div>
                </div>
              </div>
            @endfor
          </div>
        @endif

        {{-- Results --}}
        <div wire:loading.remove>
          @if($view === 'grid')
            {{-- Grid View --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
              @forelse($animes as $anime)
                <div class="animate-in" style="animation-delay: {{ ($loop->index % 5) * 0.05 }}s">
                  <x-anime-card :anime="$anime" />
                </div>
              @empty
                <div class="col-span-full">
                  <x-empty-state message="Аніме не знайдено" />
                </div>
              @endforelse
            </div>
          @else
            {{-- List View --}}
            <div class="space-y-4">
              @forelse($animes as $anime)
                <div class="animate-in" style="animation-delay: {{ min($loop->index * 0.05, 0.3) }}s">
                  @include('livewire.partials.anime-list-item', ['anime' => $anime])
                </div>
              @empty
                <x-empty-state message="Аніме не знайдено" />
              @endforelse
            </div>
          @endif
        </div>

        {{-- Pagination --}}
        @if($animes->hasPages())
          <div class="mt-10">
            {{ $animes->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Scroll to Top --}}
  <div x-data="{ showTop: false }"
       @scroll.window="showTop = window.scrollY > 500"
       class="fixed bottom-6 right-6 z-50">
    <button x-show="showTop" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="p-3 bg-cyan-500/90 hover:bg-cyan-500 text-white rounded-full shadow-lg shadow-cyan-500/25 backdrop-blur-sm transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
      </svg>
    </button>
  </div>
</div>
