@extends('main.layouts.app')

@section('title', 'Персонаж - УкрАніме')

@php $activeNav = 'characters'; @endphp

@section('content')
  <!-- Breadcrumb -->
  <div class="bg-slate-900/50 border-b border-slate-800">
    <div class="container mx-auto px-4 py-3">
      <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-cyan-400 transition-colors">Головна</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('characters.index') }}" class="text-gray-500 hover:text-cyan-400 transition-colors">Персонажі</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-300">Фрірен</span>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Left Sidebar -->
      <div class="lg:w-80 flex-shrink-0">
        <!-- Character Image -->
        <div class="relative mb-6">
          <img src="https://placehold.co/320x400/1e293b/94a3b8?text=Frieren" alt="Фрірен" class="w-full rounded-2xl shadow-2xl">
          <div class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-white font-bold rounded-lg flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            #12
          </div>
        </div>

        <!-- Action Button -->
        <button class="w-full py-3 bg-gradient-to-r from-pink-500 to-red-500 rounded-xl font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
          </svg>
          Додати до улюблених
        </button>

        <!-- Stats -->
        <div class="bg-slate-800/50 rounded-2xl p-5 mb-6">
          <h3 class="font-semibold mb-4">Статистика</h3>
          <div class="space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-gray-400">Рейтинг популярності</span>
              <span class="font-medium text-amber-400">#12</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-400">Кількість уподобань</span>
              <div class="flex items-center gap-1 text-pink-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span class="font-medium">42,150</span>
              </div>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-400">З'являється в</span>
              <span class="font-medium">2 аніме</span>
            </div>
          </div>
        </div>

        <!-- Character Info -->
        <div class="bg-slate-800/50 rounded-2xl p-5">
          <h3 class="font-semibold mb-4">Інформація</h3>
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-500">Ім'я (укр)</span>
              <span>Фрірен</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Ім'я (яп)</span>
              <span>フリーレン</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Ім'я (ромадзі)</span>
              <span>Frieren</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Стать</span>
              <span>Жінка</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Вік</span>
              <span>1000+ років</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Раса</span>
              <span>Ельф</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-500">Зріст</span>
              <span>~160 см</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="flex-grow">
        <!-- Title -->
        <div class="mb-8">
          <h1 class="text-4xl font-bold mb-2">Фрірен</h1>
          <div class="text-xl text-gray-400 mb-4">Frieren / フリーレン</div>
          <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-lg text-sm font-medium">Ельф</span>
            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-400 rounded-lg text-sm font-medium">Чарівниця</span>
            <span class="px-3 py-1 bg-pink-500/20 text-pink-400 rounded-lg text-sm font-medium">Головна героїня</span>
          </div>
        </div>

        <!-- Description -->
        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-4">Про персонажа</h2>
          <div class="text-gray-300 leading-relaxed space-y-4">
            <p>
              Фрірен - ельфійська чарівниця, яка була членом партії героїв, що перемогла Короля Демонів понад тисячу років тому. Як ельф, вона має надзвичайно довгу тривалість життя, що робить людські роки для неї миттю ока.
            </p>
            <p>
              Після смерті своїх товаришів по команді, Фрірен усвідомлює, як мало вона насправді знала про них, і вирушає у нову подорож, щоб краще зрозуміти людську природу та зберегти пам'ять про своїх друзів.
            </p>
            <p>
              Хоча Фрірен виглядає молодою дівчиною, вона насправді є однією з найсильніших чарівниць у світі. Її спеціалізація - магія знищення демонів, яку вона вивчала більше тисячі років.
            </p>
          </div>
        </section>

        <!-- Voice Actors -->
        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-6">Озвучення</h2>
          <div class="grid sm:grid-cols-2 gap-4">
            <a href="{{ route('people.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x80/1e293b/94a3b8?text=VA" alt="VA" class="w-16 h-16 object-cover rounded-full">
              <div>
                <div class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Танезакі Ацумі</div>
                <div class="text-sm text-gray-500">Японська</div>
                <div class="text-xs text-gray-400 mt-1">156 ролей</div>
              </div>
            </a>
            <a href="{{ route('people.show', 'example-slug') }}" class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/80x80/1e293b/94a3b8?text=VA" alt="VA" class="w-16 h-16 object-cover rounded-full">
              <div>
                <div class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Mallorie Rodak</div>
                <div class="text-sm text-gray-500">Англійська</div>
                <div class="text-xs text-gray-400 mt-1">24 ролі</div>
              </div>
            </a>
          </div>
        </section>

        <!-- Anime Appearances -->
        <section class="mb-10">
          <h2 class="text-2xl font-bold mb-6">З'являється в</h2>
          <div class="space-y-4">
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Frieren" alt="Frieren" class="w-24 h-32 object-cover rounded-lg">
              <div class="flex-grow">
                <div class="flex items-center gap-2 mb-1">
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs font-medium">Головна роль</span>
                </div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Похоронний обряд</h3>
                <p class="text-sm text-gray-500 mt-1">ТБ | 2023 | 28+ еп.</p>
                <div class="flex items-center gap-2 mt-2">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">9.4</span>
                </div>
              </div>
            </a>
            <a href="{{ route('anime.show', 'example-slug') }}" class="flex gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
              <img src="https://placehold.co/100x140/1e293b/94a3b8?text=OVA" alt="OVA" class="w-24 h-32 object-cover rounded-lg">
              <div class="flex-grow">
                <div class="flex items-center gap-2 mb-1">
                  <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs font-medium">Головна роль</span>
                </div>
                <h3 class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">Frieren: Спеціальний випуск</h3>
                <p class="text-sm text-gray-500 mt-1">OVA | 2024 | 1 еп.</p>
                <div class="flex items-center gap-2 mt-2">
                  <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">8.8</span>
                </div>
              </div>
            </a>
          </div>
        </section>

        <!-- Similar Characters -->
        <section>
          <h2 class="text-2xl font-bold mb-6">Схожі персонажі</h2>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/150x150/1e293b/94a3b8?text=Char" alt="Character" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
              </div>
              <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors">Емілія</h3>
              <p class="text-xs text-gray-500">Re:Zero</p>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/150x150/1e293b/94a3b8?text=Char" alt="Character" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
              </div>
              <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors">Марселла</h3>
              <p class="text-xs text-gray-500">Mushoku Tensei</p>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/150x150/1e293b/94a3b8?text=Char" alt="Character" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
              </div>
              <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors">Елейна</h3>
              <p class="text-xs text-gray-500">Подорож відьми</p>
            </a>
            <a href="{{ route('characters.show', 'example-slug') }}" class="group text-center">
              <div class="relative overflow-hidden rounded-xl mb-2">
                <img src="https://placehold.co/150x150/1e293b/94a3b8?text=Char" alt="Character" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-300">
              </div>
              <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors">Іріс</h3>
              <p class="text-xs text-gray-500">Violet Evergarden</p>
            </a>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection
