<?php

//use App\Feature\Transliterator\JapaneseToUkrainianTransliterator;
use App\Feature\Transliterator\TransliterationService;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/t', function () {
    $text = 'watashi wa nihongo o benkyou shiteimasu';

    /**
     * @var TransliterationService $service
     */
    $service = app(TransliterationService::class);
//    $service2 = app(JapaneseToUkrainianTransliterator::class);


    echo 'Service 1:' . PHP_EOL . '<br/>';
    echo 'Оригінальний текст: ' . $text . PHP_EOL . '<br/>';
    echo 'Результат: ' . $service->transliterate($text);

//    echo 'Service 2:' . PHP_EOL;
//// Результат: "ваташі ва ніхонґо о бенкйоу шітеймасу"
//    echo $service2->setMap('r2ua')->transliterate('watashi wa nihongo o benkyou shiteimasu');
});

Route::get('/i', function () {
    $service = app(AnimeImportService::class);
    $anime = $service->importSeasonalAnime(2024, 'winter', true);
//    $anime = $service->importAnimeByMalId(51711, true);
});
