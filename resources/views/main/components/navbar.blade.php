<nav class="bg-slate-900/95 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50" aria-label="Головна навігація">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-4">
      <div class="flex items-center space-x-10">
        <a href="{{ route('home') }}" class="text-2xl font-extrabold font-display bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent">
          УкрАніме
        </a>
        {{-- Mobile menu button --}}
        <button type="button" class="lg:hidden p-2 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors focus:outline-none focus:ring-2 focus:ring-cyan-500" aria-label="Відкрити меню" aria-expanded="false" onclick="document.getElementById('mobile-menu').classList.toggle('hidden'); this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false')">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="hidden lg:flex space-x-8">
          <a href="{{ route('anime.index') }}" class="{{ ($activeNav ?? '') === 'anime' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Аніме</a>
          <a href="#" class="text-gray-300 hover:text-cyan-400 font-medium transition-colors focus:outline-none focus:text-cyan-400">Манґа</a>
          <a href="{{ route('characters.index') }}" class="{{ ($activeNav ?? '') === 'characters' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Персонажі</a>
          <a href="{{ route('people.index') }}" class="{{ ($activeNav ?? '') === 'people' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Сейю</a>
          <a href="{{ route('studios.index') }}" class="{{ ($activeNav ?? '') === 'studios' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Студії</a>
          <a href="{{ route('rankings') }}" class="{{ ($activeNav ?? '') === 'rankings' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Рейтинги</a>
          <a href="{{ route('seasons') }}" class="{{ ($activeNav ?? '') === 'seasons' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors focus:outline-none focus:text-cyan-400">Сезон</a>
        </div>
      </div>
      <div class="flex items-center space-x-4">
        <div class="relative hidden md:block">
          <label for="navbar-search" class="sr-only">Пошук аніме</label>
          <input id="navbar-search" type="search" placeholder="Пошук аніме..." class="w-72 py-2.5 px-4 pl-10 rounded-xl bg-slate-800 border border-slate-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <a href="{{ route('profile') }}" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors focus:outline-none focus:ring-2 focus:ring-cyan-500" aria-label="Профіль">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </a>
        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-medium hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-slate-900">
          Увійти
        </a>
      </div>
    </div>
    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden lg:hidden pb-4 border-t border-slate-800 pt-4">
      <div class="flex flex-col space-y-3">
        <a href="{{ route('anime.index') }}" class="{{ ($activeNav ?? '') === 'anime' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Аніме</a>
        <a href="#" class="text-gray-300 hover:text-cyan-400 font-medium transition-colors py-1">Манґа</a>
        <a href="{{ route('characters.index') }}" class="{{ ($activeNav ?? '') === 'characters' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Персонажі</a>
        <a href="{{ route('people.index') }}" class="{{ ($activeNav ?? '') === 'people' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Сейю</a>
        <a href="{{ route('studios.index') }}" class="{{ ($activeNav ?? '') === 'studios' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Студії</a>
        <a href="{{ route('rankings') }}" class="{{ ($activeNav ?? '') === 'rankings' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Рейтинги</a>
        <a href="{{ route('seasons') }}" class="{{ ($activeNav ?? '') === 'seasons' ? 'text-cyan-400' : 'text-gray-300 hover:text-cyan-400' }} font-medium transition-colors py-1">Сезон</a>
      </div>
      <div class="mt-4 relative">
        <label for="navbar-search-mobile" class="sr-only">Пошук аніме</label>
        <input id="navbar-search-mobile" type="search" placeholder="Пошук аніме..." class="w-full py-2.5 px-4 pl-10 rounded-xl bg-slate-800 border border-slate-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>
  </div>
</nav>
