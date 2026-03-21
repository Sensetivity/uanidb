@props(['genre', 'active' => false])
@php
  $colors = ['bg-cyan-500/20 text-cyan-400', 'bg-purple-500/20 text-purple-400', 'bg-pink-500/20 text-pink-400', 'bg-amber-500/20 text-amber-400', 'bg-emerald-500/20 text-emerald-400'];
  $color = $active ? 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 font-medium' : $colors[$genre->id % count($colors)];
@endphp
<span {{ $attributes->merge(['class' => "px-2 py-0.5 rounded text-xs {$color}"]) }}>
  {{ $genre->name ?: $genre->mal_title }}
</span>
