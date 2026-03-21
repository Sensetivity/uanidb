@props(['title', 'subtitle' => null])
<div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 border-b border-slate-800">
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-2">{{ $title }}</h1>
    @if($subtitle)
      <p class="text-gray-400">{{ $subtitle }}</p>
    @endif
  </div>
</div>
