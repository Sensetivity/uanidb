@extends('main.layouts.app')

@section('title', 'Сейю - УкрАніме')

@php $activeNav = 'people'; @endphp

@section('content')
  <div class="bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-b border-slate-800">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-4xl font-bold mb-2">Сейю (Актори озвучення)</h1>
      <p class="text-gray-400">Каталог акторів озвучення</p>
    </div>
  </div>

  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-slate-900/50 rounded-2xl">
      <div class="flex items-center gap-2">
        <span class="text-sm text-gray-500">Сортувати:</span>
        <select onchange="window.location.href='{{ route('people.index') }}?sort=' + this.value"
                class="py-2 px-3 rounded-lg bg-slate-800 border border-slate-700 text-gray-300 text-sm focus:outline-none focus:border-cyan-500 transition-all">
          @foreach(\App\Enums\PersonSortEnum::cases() as $option)
            <option value="{{ $option->value }}" @selected($sort === $option)>{{ $option->getLabel() }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex-grow"></div>
      <span class="text-gray-400 text-sm">Знайдено: <span class="text-white font-medium">{{ number_format($people->total()) }}</span> сейю</span>
    </div>

    @if($people->isEmpty())
      <x-empty-state message="Сейю не знайдено" />
    @else
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
        @foreach($people as $person)
          <a href="{{ route('people.show', $person->slug) }}" class="group text-center" wire:navigate>
            <div class="relative overflow-hidden rounded-2xl mb-3">
              <img src="{{ $person->image_display_url ?? 'https://placehold.co/200x200/1e293b/94a3b8?text=' . urlencode(mb_substr($person->name, 0, 1)) }}"
                   alt="{{ $person->name }}"
                   class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300"
                   loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
              @if($person->voiced_characters_count)
                <div class="absolute bottom-2 left-2 right-2 text-sm text-gray-300">
                  {{ $person->voiced_characters_count }} {{ trans_choice('роль|ролі|ролей', $person->voiced_characters_count) }}
                </div>
              @endif
            </div>
            <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-1">{{ $person->name }}</h3>
          </a>
        @endforeach
      </div>

      <div class="mt-10">
        {{ $people->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
