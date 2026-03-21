<div>
  <!-- Tabs Navigation -->
  <div class="border-b border-slate-800 mb-8">
    <div class="flex gap-8 overflow-x-auto scrollbar-hide">
      @foreach(['overview' => 'Огляд', 'characters' => 'Персонажі', 'episodes' => 'Епізоди', 'staff' => 'Команда', 'related' => "Пов'язані"] as $tab => $label)
        <button
          wire:click="selectTab('{{ $tab }}')"
          class="pb-4 border-b-2 font-medium whitespace-nowrap transition-colors {{ $activeTab === $tab ? 'border-cyan-500 text-cyan-400' : 'border-transparent text-gray-400 hover:text-gray-200' }}"
        >
          {{ $label }}
          @if($tab === 'episodes')
            <span class="text-xs text-gray-500 ml-1">({{ $anime->episodes_count ?? $anime->episodes()->count() }})</span>
          @endif
        </button>
      @endforeach
    </div>
  </div>

  <!-- Tab Content -->
  <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity">
    @if($activeTab === 'overview')
      {{-- Synopsis --}}
      <section class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Опис</h2>
        @if($anime->synopsis_uk)
          <div class="text-gray-300 leading-relaxed space-y-4">
            {!! nl2br(e($anime->synopsis_uk)) !!}
          </div>
        @elseif($anime->synopsis)
          <div class="text-gray-300 leading-relaxed space-y-4">
            {!! nl2br(e($anime->synopsis)) !!}
          </div>
        @else
          <p class="text-gray-500">Опис відсутній.</p>
        @endif
      </section>

      {{-- Promotion Videos --}}
      @if($anime->promotionVideos->isNotEmpty())
        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-4">Відео</h2>
          <div class="grid md:grid-cols-2 gap-4">
            @foreach($anime->promotionVideos->take(4) as $video)
              <div class="relative aspect-video bg-slate-800 rounded-2xl overflow-hidden">
                @if($video->video_id)
                  <iframe
                    src="https://www.youtube.com/embed/{{ $video->video_id }}"
                    class="w-full h-full"
                    allowfullscreen
                    loading="lazy"
                    title="{{ $video->title }}"
                  ></iframe>
                @else
                  <div class="w-full h-full flex items-center justify-center text-gray-500">
                    {{ $video->title }}
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </section>
      @endif

    @elseif($activeTab === 'characters')
      <section>
        <h2 class="text-2xl font-bold mb-6">Персонажі</h2>
        @if($this->characters->isEmpty())
          <x-empty-state message="Персонажів ще не додано." />
        @else
          <div class="grid md:grid-cols-2 gap-4">
            @foreach($this->characters as $character)
              <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                <a href="{{ route('characters.show', $character->slug) }}" wire:navigate class="w-20 flex-shrink-0">
                  <img
                    src="{{ $character->image_display_url ?? 'https://placehold.co/80x112/1e293b/94a3b8?text=?' }}"
                    alt="{{ $character->name }}"
                    loading="lazy"
                    class="w-full h-full object-cover"
                  >
                </a>
                <div class="flex-grow p-4">
                  <a href="{{ route('characters.show', $character->slug) }}" wire:navigate class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">
                    {{ $character->name }}
                  </a>
                  <div class="text-sm text-gray-500">{{ $character->pivot->role }}</div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

    @elseif($activeTab === 'episodes')
      <section>
        <h2 class="text-2xl font-bold mb-6">Епізоди</h2>
        @if($this->episodes->isEmpty())
          <x-empty-state message="Епізодів ще не додано." />
        @else
          <div class="space-y-3">
            @foreach($this->episodes as $episode)
              <div class="bg-slate-800/50 rounded-xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center text-gray-400 font-bold flex-shrink-0">
                  {{ $episode->number }}
                </div>
                <div class="flex-grow min-w-0">
                  <div class="font-medium text-gray-200 truncate">
                    {{ $episode->title_uk ?: $episode->title ?: $episode->title_en ?: "Епізод {$episode->number}" }}
                  </div>
                  @if($episode->aired)
                    <div class="text-sm text-gray-500">{{ $episode->aired->format('d.m.Y') }}</div>
                  @endif
                </div>
                @if($episode->duration)
                  <div class="text-sm text-gray-500 flex-shrink-0">{{ $episode->duration }} хв.</div>
                @endif
              </div>
            @endforeach
          </div>
        @endif
      </section>

    @elseif($activeTab === 'staff')
      <section>
        <h2 class="text-2xl font-bold mb-6">Команда</h2>
        @if($this->staff->isEmpty())
          <x-empty-state message="Інформацію про команду ще не додано." />
        @else
          <div class="grid md:grid-cols-2 gap-4">
            @foreach($this->staff as $person)
              <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                <a href="{{ route('people.show', $person->slug) }}" wire:navigate class="w-20 flex-shrink-0">
                  <img
                    src="{{ $person->image_display_url ?? 'https://placehold.co/80x112/1e293b/94a3b8?text=?' }}"
                    alt="{{ $person->name }}"
                    loading="lazy"
                    class="w-full h-full object-cover"
                  >
                </a>
                <div class="flex-grow p-4">
                  <a href="{{ route('people.show', $person->slug) }}" wire:navigate class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">
                    {{ $person->name }}
                  </a>
                  <div class="text-sm text-gray-500">{{ $person->pivot->role }}</div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

    @elseif($activeTab === 'related')
      <section>
        <h2 class="text-2xl font-bold mb-6">Пов'язані аніме</h2>
        @if($this->relatedAnime->isEmpty())
          <x-empty-state message="Пов'язаних аніме не знайдено." />
        @else
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($this->relatedAnime as $related)
              <div>
                <x-anime-card :anime="$related" />
                <p class="text-xs text-gray-500 mt-1">{{ $related->pivot->relation_type }}</p>
              </div>
            @endforeach
          </div>
        @endif
      </section>
    @endif
  </div>
</div>
