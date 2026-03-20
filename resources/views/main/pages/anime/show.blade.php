@php $activeNav = 'anime'; @endphp

@extends('main.layouts.app')

@section('title', 'Деталі аніме - УкрАніме')


@section('content')

    <!-- Breadcrumb -->
    <div class="bg-slate-900/50 border-b border-slate-800">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-cyan-400 transition-colors">Головна</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('anime.index') }}"
                   class="text-gray-500 hover:text-cyan-400 transition-colors">Аніме</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-300">Frieren: Похоронний обряд</span>
            </div>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="relative h-80 overflow-hidden">
        <img src="https://placehold.co/1920x400/1e293b/94a3b8?text=Banner" alt="Banner"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 to-transparent"></div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-48 relative z-10">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Sidebar -->
            <div class="lg:w-80 flex-shrink-0">
                <!-- Poster -->
                <div class="relative mb-6">
                    <img src="https://placehold.co/320x450/1e293b/94a3b8?text=Frieren" alt="Frieren"
                         class="w-full rounded-2xl shadow-2xl">
                    <div class="absolute top-4 left-4 px-3 py-1 bg-cyan-500 text-white font-bold rounded-lg">
                        9.4
                    </div>
                    <div class="absolute top-4 right-4 px-3 py-1 bg-amber-500 text-white font-bold rounded-lg flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        #1
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3 mb-6">
                    <button class="w-full py-3 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-xl font-semibold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Додати до списку
                    </button>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="py-3 bg-slate-800 border border-slate-700 rounded-xl font-medium flex items-center justify-center gap-2 hover:bg-slate-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Вподобати
                        </button>
                        <button class="py-3 bg-slate-800 border border-slate-700 rounded-xl font-medium flex items-center justify-center gap-2 hover:bg-slate-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Поділитись
                        </button>
                    </div>
                </div>

                <!-- Rating Card -->
                <div class="bg-slate-800/50 rounded-2xl p-5 mb-6">
                    <div class="text-center mb-4">
                        <div class="text-5xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                            9.4
                        </div>
                        <div class="text-gray-500 text-sm mt-1">на основі 15,423 оцінок</div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Сюжет</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full"
                                         style="width: 96%"></div>
                                </div>
                                <span class="text-sm font-medium w-8">9.6</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Анімація</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full"
                                         style="width: 98%"></div>
                                </div>
                                <span class="text-sm font-medium w-8">9.8</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Персонажі</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full"
                                         style="width: 94%"></div>
                                </div>
                                <span class="text-sm font-medium w-8">9.4</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Музика</span>
                            <div class="flex items-center gap-2">
                                <div class="w-32 h-2 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full"
                                         style="width: 90%"></div>
                                </div>
                                <span class="text-sm font-medium w-8">9.0</span>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-medium transition-colors">
                        Оцінити
                    </button>
                </div>

                <!-- Info Card -->
                <div class="bg-slate-800/50 rounded-2xl p-5">
                    <h3 class="font-semibold mb-4">Інформація</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Тип</span>
                            <span>ТБ серіал</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Епізоди</span>
                            <span>28 / ?</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Статус</span>
                            <span class="text-green-400">Виходить</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Сезон</span>
                            <span>Осінь 2023</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Студія</span>
                            <a href="{{ route('studios.show', 'example-slug') }}"
                               class="text-cyan-400 hover:text-cyan-300">Madhouse</a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Джерело</span>
                            <span>Манґа</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Рейтинг</span>
                            <span>PG-13</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Тривалість</span>
                            <span>24 хв</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow">
                <!-- Title Section -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold mb-2">Frieren: Похоронний обряд</h1>
                    <div class="text-xl text-gray-400 mb-4">Sousou no Frieren / 葬送のフリーレン</div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-cyan-500/20 text-cyan-400 rounded-lg text-sm font-medium">Пригоди</span>
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-lg text-sm font-medium">Драма</span>
                        <span class="px-3 py-1 bg-pink-500/20 text-pink-400 rounded-lg text-sm font-medium">Фентезі</span>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-slate-800 mb-8">
                    <div class="flex gap-8 overflow-x-auto scrollbar-hide">
                        <button class="pb-4 border-b-2 border-cyan-500 text-cyan-400 font-medium whitespace-nowrap">
                            Огляд
                        </button>
                        <button class="pb-4 border-b-2 border-transparent text-gray-400 hover:text-gray-200 font-medium whitespace-nowrap">
                            Персонажі
                        </button>
                        <button class="pb-4 border-b-2 border-transparent text-gray-400 hover:text-gray-200 font-medium whitespace-nowrap">
                            Епізоди
                        </button>
                        <button class="pb-4 border-b-2 border-transparent text-gray-400 hover:text-gray-200 font-medium whitespace-nowrap">
                            Команда
                        </button>
                        <button class="pb-4 border-b-2 border-transparent text-gray-400 hover:text-gray-200 font-medium whitespace-nowrap">
                            Відгуки
                        </button>
                        <button class="pb-4 border-b-2 border-transparent text-gray-400 hover:text-gray-200 font-medium whitespace-nowrap">
                            Статистика
                        </button>
                    </div>
                </div>

                <!-- Synopsis -->
                <section class="mb-10">
                    <h2 class="text-2xl font-bold mb-4">Опис</h2>
                    <div class="text-gray-300 leading-relaxed space-y-4">
                        <p>
                            Героїня Гіммель та його відважна команда нарешті перемогли Короля Демонів після десятирічної
                            подорожі. Тепер ельфійська чарівниця Фрірен та її товариші повертаються додому до
                            королівства, яке святкує їхню перемогу.
                        </p>
                        <p>
                            Фрірен живе понад тисячу років, тому п'ятдесят років для неї - мить ока. Коли вона нарешті
                            повертається назад, її старі друзі вже прожили своє життя. Тоді Фрірен усвідомлює, як мало
                            вона знала про своїх товаришів, і вирушає в нову подорож, щоб зрозуміти людську природу та
                            віддати належне пам'яті своїх друзів.
                        </p>
                    </div>
                </section>

                <!-- Trailer -->
                <section class="mb-10">
                    <h2 class="text-2xl font-bold mb-4">Трейлер</h2>
                    <div class="relative aspect-video bg-slate-800 rounded-2xl overflow-hidden">
                        <img src="https://placehold.co/800x450/1e293b/94a3b8?text=Video+Trailer" alt="Trailer"
                             loading="lazy" class="w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white ml-1"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Characters -->
                <section class="mb-10">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Персонажі та сейю</h2>
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі персонажі</a>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Character Card -->
                        <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                            <a href="{{ route('characters.show', 'example-slug') }}" class="w-24 flex-shrink-0">
                                <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Frieren" alt="Frieren"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-grow p-4 flex justify-between">
                                <div>
                                    <a href="{{ route('characters.show', 'example-slug') }}"
                                       class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">Фрірен</a>
                                    <div class="text-sm text-gray-500">Головна роль</div>
                                    <div class="mt-2 flex items-center gap-1 text-amber-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                             viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>42,150</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('people.show', 'example-slug') }}"
                                       class="font-medium text-gray-300 hover:text-cyan-400 transition-colors">Танезакі
                                        Ацумі</a>
                                    <div class="text-sm text-gray-500">Японська</div>
                                </div>
                            </div>
                            <a href="{{ route('people.show', 'example-slug') }}" class="w-20 flex-shrink-0">
                                <img src="https://placehold.co/80x140/1e293b/94a3b8?text=VA" alt="VA"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                        </div>
                        <!-- Character Card -->
                        <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                            <a href="{{ route('characters.show', 'example-slug') }}" class="w-24 flex-shrink-0">
                                <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Fern" alt="Fern"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-grow p-4 flex justify-between">
                                <div>
                                    <a href="{{ route('characters.show', 'example-slug') }}"
                                       class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">Ферн</a>
                                    <div class="text-sm text-gray-500">Головна роль</div>
                                    <div class="mt-2 flex items-center gap-1 text-amber-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                             viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>38,420</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('people.show', 'example-slug') }}"
                                       class="font-medium text-gray-300 hover:text-cyan-400 transition-colors">Ітікава
                                        Маріа</a>
                                    <div class="text-sm text-gray-500">Японська</div>
                                </div>
                            </div>
                            <a href="{{ route('people.show', 'example-slug') }}" class="w-20 flex-shrink-0">
                                <img src="https://placehold.co/80x140/1e293b/94a3b8?text=VA" alt="VA"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                        </div>
                        <!-- Character Card -->
                        <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                            <a href="{{ route('characters.show', 'example-slug') }}" class="w-24 flex-shrink-0">
                                <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Stark" alt="Stark"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-grow p-4 flex justify-between">
                                <div>
                                    <a href="{{ route('characters.show', 'example-slug') }}"
                                       class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">Штарк</a>
                                    <div class="text-sm text-gray-500">Головна роль</div>
                                    <div class="mt-2 flex items-center gap-1 text-amber-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                             viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>32,180</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('people.show', 'example-slug') }}"
                                       class="font-medium text-gray-300 hover:text-cyan-400 transition-colors">Кобаясі
                                        Тіорі</a>
                                    <div class="text-sm text-gray-500">Японська</div>
                                </div>
                            </div>
                            <a href="{{ route('people.show', 'example-slug') }}" class="w-20 flex-shrink-0">
                                <img src="https://placehold.co/80x140/1e293b/94a3b8?text=VA" alt="VA"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                        </div>
                        <!-- Character Card -->
                        <div class="bg-slate-800/50 rounded-xl overflow-hidden flex">
                            <a href="{{ route('characters.show', 'example-slug') }}" class="w-24 flex-shrink-0">
                                <img src="https://placehold.co/100x140/1e293b/94a3b8?text=Himmel" alt="Himmel"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-grow p-4 flex justify-between">
                                <div>
                                    <a href="{{ route('characters.show', 'example-slug') }}"
                                       class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">Гіммель</a>
                                    <div class="text-sm text-gray-500">Другорядна роль</div>
                                    <div class="mt-2 flex items-center gap-1 text-amber-400 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                             viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>28,750</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('people.show', 'example-slug') }}"
                                       class="font-medium text-gray-300 hover:text-cyan-400 transition-colors">Окамото
                                        Нобухіко</a>
                                    <div class="text-sm text-gray-500">Японська</div>
                                </div>
                            </div>
                            <a href="{{ route('people.show', 'example-slug') }}" class="w-20 flex-shrink-0">
                                <img src="https://placehold.co/80x140/1e293b/94a3b8?text=VA" alt="VA"
                                     loading="lazy" class="w-full h-full object-cover">
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Related Anime -->
                <section class="mb-10">
                    <h2 class="text-2xl font-bold mb-6">Пов'язане</h2>
                    <div class="space-y-3">
                        <a href="#"
                           class="flex items-center gap-4 p-4 bg-slate-800/50 rounded-xl hover:bg-slate-800 transition-colors group">
                            <img src="https://placehold.co/80x110/1e293b/94a3b8?text=Manga" alt="Manga"
                                 loading="lazy" class="w-16 h-22 object-cover rounded-lg">
                            <div class="flex-grow">
                                <div class="text-xs text-purple-400 font-medium mb-1">Адаптація</div>
                                <div class="font-semibold text-gray-200 group-hover:text-cyan-400 transition-colors">
                                    Frieren: Beyond Journey's End (Манґа)
                                </div>
                                <div class="text-sm text-gray-500">Манґа, 2020</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </section>

                <!-- Reviews -->
                <section class="mb-10">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Відгуки</h2>
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі відгуки (156)</a>
                    </div>
                    <div class="space-y-4">
                        <!-- Review Card -->
                        <div class="bg-slate-800/50 rounded-xl p-5">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="https://placehold.co/48x48/1e293b/94a3b8?text=U" alt="User"
                                     loading="lazy" class="w-12 h-12 rounded-full">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-3 mb-1">
                                        <a href="{{ route('profile') }}"
                                           class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">AnimeFan_UA</a>
                                        <div class="flex items-center gap-1 text-cyan-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span class="font-medium">10</span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">3 дні тому</div>
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed mb-4">
                                Це аніме - справжній шедевр! Історія про безсмертну ельфійку, яка вчиться цінувати
                                людські стосунки, зачіпає душу. Анімація від Madhouse на найвищому рівні, кожен кадр -
                                витвір мистецтва. Музика ідеально підкреслює емоційні моменти. Рекомендую всім!
                            </p>
                            <div class="flex items-center gap-4 text-sm">
                                <button class="flex items-center gap-2 text-gray-500 hover:text-cyan-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                    Корисно (42)
                                </button>
                                <button class="text-gray-500 hover:text-gray-300 transition-colors">Відповісти</button>
                            </div>
                        </div>
                        <!-- Review Card -->
                        <div class="bg-slate-800/50 rounded-xl p-5">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="https://placehold.co/48x48/1e293b/94a3b8?text=U" alt="User"
                                     loading="lazy" class="w-12 h-12 rounded-full">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-3 mb-1">
                                        <a href="{{ route('profile') }}"
                                           class="font-semibold text-gray-200 hover:text-cyan-400 transition-colors">OtakuMaster</a>
                                        <div class="flex items-center gap-1 text-cyan-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                                 viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                            <span class="font-medium">9</span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">1 тиждень тому</div>
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed mb-4">
                                Frieren - це повільне, споглядальне аніме з глибоким філософським підтекстом. Не для
                                тих, хто шукає екшн. Але якщо ви цінуєте красиву історію про час, пам'ять та людські
                                зв'язки - це must-watch.
                            </p>
                            <div class="flex items-center gap-4 text-sm">
                                <button class="flex items-center gap-2 text-gray-500 hover:text-cyan-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                    Корисно (28)
                                </button>
                                <button class="text-gray-500 hover:text-gray-300 transition-colors">Відповісти</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Recommendations -->
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Рекомендації</h2>
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium">Усі рекомендації</a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
                            <div class="relative mb-2">
                                <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                                        <h4 class="font-semibold text-gray-200 text-sm mb-1">Violet Evergarden</h4>
                                        <p class="text-xs text-gray-500 mb-2">Kyoto Animation • Зима 2018</p>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                                            <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Фентезі</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Violet"
                                         alt="Violet Evergarden" loading="lazy"
                                         class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">
                                        9.0
                                    </div>
                                </div>
                                @include('main.components.anime-list-menu')
                            </div>
                            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">
                                Violet Evergarden</h3>
                        </a>
                        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
                            <div class="relative mb-2">
                                <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                                        <h4 class="font-semibold text-gray-200 text-sm mb-1">Made in Abyss</h4>
                                        <p class="text-xs text-gray-500 mb-2">Kinema Citrus • Літо 2017</p>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Пригоди</span>
                                            <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Made+in+Abyss" loading="lazy"
                                         alt="Made in Abyss"
                                         class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">
                                        8.8
                                    </div>
                                </div>
                                @include('main.components.anime-list-menu')
                            </div>
                            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">
                                Made in Abyss</h3>
                        </a>
                        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
                            <div class="relative mb-2">
                                <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                                        <h4 class="font-semibold text-gray-200 text-sm mb-1">Mushoku Tensei</h4>
                                        <p class="text-xs text-gray-500 mb-2">Studio Bind • Зима 2021</p>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Фентезі</span>
                                            <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Пригоди</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Mushoku" loading="lazy"
                                         alt="Mushoku Tensei"
                                         class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">
                                        8.6
                                    </div>
                                </div>
                                @include('main.components.anime-list-menu')
                            </div>
                            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">
                                Mushoku Tensei</h3>
                        </a>
                        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
                            <div class="relative mb-2">
                                <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                                        <h4 class="font-semibold text-gray-200 text-sm mb-1">Spice and Wolf</h4>
                                        <p class="text-xs text-gray-500 mb-2">Brain's Base • Зима 2008</p>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-2 py-0.5 bg-pink-500/20 text-pink-400 rounded text-xs">Романтика</span>
                                            <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://placehold.co/180x250/1e293b/94a3b8?text=Spice" loading="lazy"
                                         alt="Spice and Wolf"
                                         class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">
                                        8.4
                                    </div>
                                </div>
                                @include('main.components.anime-list-menu')
                            </div>
                            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">
                                Spice and Wolf</h3>
                        </a>
                        <a href="{{ route('anime.show', 'example-slug') }}" class="group">
                            <div class="relative mb-2">
                                <div class="absolute left-full top-0 ml-2 w-56 z-50 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all delay-300 duration-200">
                                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-3">
                                        <h4 class="font-semibold text-gray-200 text-sm mb-1">March Comes in Like a
                                            Lion</h4>
                                        <p class="text-xs text-gray-500 mb-2">Shaft • Осінь 2016</p>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-2 py-0.5 bg-purple-500/20 text-purple-400 rounded text-xs">Драма</span>
                                            <span class="px-2 py-0.5 bg-cyan-500/20 text-cyan-400 rounded text-xs">Повсякденність</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="https://placehold.co/180x250/1e293b/94a3b8?text=March" loading="lazy"
                                         alt="March Comes in Like a Lion"
                                         class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                    <div class="absolute top-2 left-2 px-2 py-0.5 bg-cyan-500 text-white text-xs font-bold rounded">
                                        8.9
                                    </div>
                                </div>
                                @include('main.components.anime-list-menu')
                            </div>
                            <h3 class="font-medium text-sm text-gray-300 group-hover:text-cyan-400 transition-colors line-clamp-2">
                                March Comes in Like a Lion</h3>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Footer -->
@endsection

@push('scripts')
@include('main.components.list-menu-script')
@endpush
