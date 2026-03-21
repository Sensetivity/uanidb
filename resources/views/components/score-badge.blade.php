@props(['score' => null])
@if($score)
  <span {{ $attributes->merge(['class' => 'px-2 py-1 bg-cyan-500 text-white text-xs font-bold rounded-lg']) }}>
    {{ number_format($score, 1) }}
  </span>
@endif
