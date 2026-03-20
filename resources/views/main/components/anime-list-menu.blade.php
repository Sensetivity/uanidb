{{-- Anime list dropdown menu - appears on card hover --}}
<div class="absolute bottom-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity list-menu-container">
  <div class="relative">
    <button type="button" onclick="toggleListMenu(event, this)" class="w-8 h-8 bg-slate-900/90 backdrop-blur-sm rounded-lg flex items-center justify-center hover:bg-cyan-500 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
    </button>
    <div class="list-dropdown hidden absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
      <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /></svg>
        Дивлюсь
      </button>
      <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
        Заплановано
      </button>
      <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        Переглянуто
      </button>
      <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-cyan-400 transition-colors flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        Кинув
      </button>
      <div class="border-t border-slate-700"></div>
      <button type="button" class="w-full px-4 py-2.5 text-left text-sm text-gray-300 hover:bg-slate-700 hover:text-red-400 transition-colors flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
        Улюблене
      </button>
    </div>
  </div>
</div>
