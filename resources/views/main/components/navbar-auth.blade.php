<nav class="bg-slate-900/95 backdrop-blur-md border-b border-slate-800" aria-label="Навігація">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-4">
      <a href="{{ route('home') }}" class="text-2xl font-extrabold font-display bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent">
        УкрАніме
      </a>
      <div class="hidden md:flex space-x-8">
        <a href="{{ route('anime.index') }}" class="text-gray-300 hover:text-cyan-400 font-medium transition-colors focus:outline-none focus:text-cyan-400">Аніме</a>
        <a href="{{ route('characters.index') }}" class="text-gray-300 hover:text-cyan-400 font-medium transition-colors focus:outline-none focus:text-cyan-400">Персонажі</a>
        <a href="{{ route('rankings') }}" class="text-gray-300 hover:text-cyan-400 font-medium transition-colors focus:outline-none focus:text-cyan-400">Рейтинги</a>
      </div>
    </div>
  </div>
</nav>
