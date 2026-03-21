@props(['status'])
@php
  $color = match($status) {
    \App\Enums\AnimeStatusEnum::AIRING => 'bg-green-500/20 text-green-400',
    \App\Enums\AnimeStatusEnum::FINISHED => 'bg-blue-500/20 text-blue-400',
    \App\Enums\AnimeStatusEnum::NOT_YET_AIRED => 'bg-amber-500/20 text-amber-400',
    default => 'bg-gray-500/20 text-gray-400',
  };
@endphp
<span {{ $attributes->merge(['class' => "px-2 py-0.5 rounded text-xs {$color}"]) }}>
  {{ $status->getLabel() }}
</span>
