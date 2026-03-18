<?php

namespace Tests\Unit;

use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;
use App\Services\Transliteration\Providers\KovalenkoTransliterationProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class KovalenkoTransliterationProviderTest extends TestCase
{
    private KovalenkoTransliterationProvider $provider;

    // ─── Capitalization ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function capitalizationProvider(): array
    {
        return [
            'first letter cap' => ['Tanaka', 'Танака'],
            'compound first cap' => ['Shimizu', 'Шімідзу'],
            'kyo cap' => ['Tokyo', 'Токьо'],
            'all lowercase' => ['naruto', 'наруто'],
            'first letter cap multi-word' => ['Tanaka Taro', 'Танака Таро'],
            'cap after space' => ['Sato Kenji', 'Сато Кенджі'],
        ];
    }

    // ─── Special Rule 5: ee doubling ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function eeDoublingProvider(): array
    {
        return [
            'ee in word' => ['oneesan', 'онеісан'],
            'ee at end' => ['nee', 'неі'],
            'single e (no doubling)' => ['ne', 'не'],
        ];
    }

    // ─── Full anime/character names ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function fullNamesProvider(): array
    {
        return [
            'Tanaka' => ['tanaka', 'танака'],
            'Shimizu' => ['shimizu', 'шімідзу'],
            'Tokyo' => ['tokyo', 'токьо'],
            'Kyoto' => ['kyoto', 'кьото'],
            'Naruto' => ['naruto', 'наруто'],
            'Sasuke' => ['sasuke', 'сасуке'],
            'Sakura' => ['sakura', 'сакура'],
            'Kakashi' => ['kakashi', 'какаші'],
            'Hokage' => ['hokage', 'хокаґе'],
            'Goku' => ['goku', 'ґоку'],
            'Fujimoto' => ['fujimoto', 'фуджімото'],
            'Takeshi' => ['takeshi', 'такеші'],
            'Haruka' => ['haruka', 'харука'],
            'Ryunosuke' => ['ryunosuke', 'рюносуке'],
        ];
    }

    // ─── Hiragana: complete coverage ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function hiraganaBasicProvider(): array
    {
        return [
            // vowels
            'a' => ['あ', 'а'],
            'i' => ['い', 'і'],
            'u' => ['う', 'у'],
            'e' => ['え', 'е'],
            'o' => ['お', 'о'],
            // ka-row
            'ka' => ['か', 'ка'],
            'ki' => ['き', 'кі'],
            'ku' => ['く', 'ку'],
            'ke' => ['け', 'ке'],
            'ko' => ['こ', 'ко'],
            // ga-row
            'ga' => ['が', 'ґа'],
            'gi' => ['ぎ', 'ґі'],
            'gu' => ['ぐ', 'ґу'],
            'ge' => ['げ', 'ґе'],
            'go' => ['ご', 'ґо'],
            // sa-row
            'sa' => ['さ', 'са'],
            'shi' => ['し', 'ші'],
            'su' => ['す', 'су'],
            'se' => ['せ', 'се'],
            'so' => ['そ', 'со'],
            // za-row
            'za' => ['ざ', 'дза'],
            'ji' => ['じ', 'джі'],
            'zu' => ['ず', 'дзу'],
            'ze' => ['ぜ', 'дзе'],
            'zo' => ['ぞ', 'дзо'],
            // ta-row
            'ta' => ['た', 'та'],
            'chi' => ['ち', 'чі'],
            'tsu' => ['つ', 'цу'],
            'te' => ['て', 'те'],
            'to' => ['と', 'то'],
            // da-row
            'da' => ['だ', 'да'],
            'de' => ['で', 'де'],
            'do' => ['ど', 'до'],
            // na-row
            'na' => ['な', 'на'],
            'ni' => ['に', 'ні'],
            'nu' => ['ぬ', 'ну'],
            'ne' => ['ね', 'не'],
            'no' => ['の', 'но'],
            // ha-row
            'ha' => ['は', 'ха'],
            'hi' => ['ひ', 'хі'],
            'fu' => ['ふ', 'фу'],
            'he' => ['へ', 'хе'],
            'ho' => ['ほ', 'хо'],
            // ba-row
            'ba' => ['ば', 'ба'],
            'bi' => ['び', 'бі'],
            'bu' => ['ぶ', 'бу'],
            'be' => ['べ', 'бе'],
            'bo' => ['ぼ', 'бо'],
            // pa-row
            'pa' => ['ぱ', 'па'],
            'pi' => ['ぴ', 'пі'],
            'pu' => ['ぷ', 'пу'],
            'pe' => ['ぺ', 'пе'],
            'po' => ['ぽ', 'по'],
            // ma-row
            'ma' => ['ま', 'ма'],
            'mi' => ['み', 'мі'],
            'mu' => ['む', 'му'],
            'me' => ['め', 'ме'],
            'mo' => ['も', 'мо'],
            // ya-row
            'ya' => ['や', 'я'],
            'yu' => ['ゆ', 'ю'],
            'yo' => ['よ', 'йо'],
            // ra-row
            'ra' => ['ら', 'ра'],
            'ri' => ['り', 'рі'],
            'ru' => ['る', 'ру'],
            're' => ['れ', 'ре'],
            'ro' => ['ろ', 'ро'],
            // wa-row
            'wa' => ['わ', 'ва'],
            'wo' => ['を', 'о'],
            // n
            'n' => ['ん', 'н'],
        ];
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function hiraganaCompoundProvider(): array
    {
        return [
            'kya' => ['きゃ', 'кя'],
            'kyu' => ['きゅ', 'кю'],
            'kyo' => ['きょ', 'кьо'],
            'gya' => ['ぎゃ', 'ґя'],
            'gyu' => ['ぎゅ', 'ґю'],
            'gyo' => ['ぎょ', 'ґьо'],
            'sha' => ['しゃ', 'шя'],
            'shu' => ['しゅ', 'шю'],
            'sho' => ['しょ', 'шьо'],
            'ja' => ['じゃ', 'джя'],
            'ju' => ['じゅ', 'джю'],
            'jo' => ['じょ', 'джьо'],
            'cha' => ['ちゃ', 'чя'],
            'chu' => ['ちゅ', 'чю'],
            'cho' => ['ちょ', 'чьо'],
            'nya' => ['にゃ', 'ня'],
            'nyu' => ['にゅ', 'ню'],
            'nyo' => ['にょ', 'ньо'],
            'hya' => ['ひゃ', 'хя'],
            'hyu' => ['ひゅ', 'хю'],
            'hyo' => ['ひょ', 'хьо'],
            'bya' => ['びゃ', 'бя'],
            'byu' => ['びゅ', 'бю'],
            'byo' => ['びょ', 'бьо'],
            'pya' => ['ぴゃ', 'пя'],
            'pyu' => ['ぴゅ', 'пю'],
            'pyo' => ['ぴょ', 'пьо'],
            'mya' => ['みゃ', 'мя'],
            'myu' => ['みゅ', 'мю'],
            'myo' => ['みょ', 'мьо'],
            'rya' => ['りゃ', 'ря'],
            'ryu' => ['りゅ', 'рю'],
            'ryo' => ['りょ', 'рьо'],
        ];
    }

    // ─── Special Rule 2: ie → є ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function ieRuleProvider(): array
    {
        return [
            'ie standalone' => ['ie', 'іє'],
            'ie in word' => ['kie', 'кіє'],
            'ie mid-word' => ['kieta', 'кієта'],
        ];
    }

    #[Test]
    #[DataProvider('eeDoublingProvider')]
    public function it_applies_ee_doubling_rule(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('ieRuleProvider')]
    public function it_applies_ie_to_ye_rule(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    // ─── Multiple special rules in one word ───

    #[Test]
    public function it_applies_multiple_special_rules_in_one_word(): void
    {
        // shinpai: n→м before p + vowel+i→й at end
        $this->assertSame('шімпай', $this->provider->transliterate('shinpai', ScriptTypeEnum::Romaji));

        // ookii: oo doubling + vowel+i→й at end (i after i is vowel+i)
        $result = $this->provider->transliterate('ookii', ScriptTypeEnum::Romaji);
        $this->assertStringStartsWith('оукі', $result);
    }

    #[Test]
    #[DataProvider('nAssimilationProvider')]
    public function it_applies_n_assimilation_rule(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('ooDoublingProvider')]
    public function it_applies_oo_doubling_rule(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('vowelPlusIProvider')]
    public function it_applies_vowel_plus_i_rule(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('capitalizationProvider')]
    public function it_handles_capitalization(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_handles_empty_string(): void
    {
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Romaji));
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Hiragana));
        $this->assertSame('', $this->provider->transliterate('', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_handles_hiragana_with_spaces(): void
    {
        $this->assertSame('та на ка', $this->provider->transliterate('た な か', ScriptTypeEnum::Hiragana));
    }

    #[Test]
    public function it_handles_katakana_with_spaces(): void
    {
        $this->assertSame('та ка ко', $this->provider->transliterate('タ カ コ', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_handles_long_vowel_mark_in_katakana_context(): void
    {
        // ラーメン = ra + ー + me + n
        $this->assertSame('рамен', $this->provider->transliterate('ラーメン', ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_handles_mixed_known_and_unknown_characters(): void
    {
        $this->assertSame('ка1ку', $this->provider->transliterate('ka1ku', ScriptTypeEnum::Romaji));
        $this->assertSame('танака!', $this->provider->transliterate('tanaka!', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_handles_single_character(): void
    {
        $this->assertSame('а', $this->provider->transliterate('a', ScriptTypeEnum::Romaji));
        $this->assertSame('н', $this->provider->transliterate('n', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_handles_unmatched_consonants(): void
    {
        // Standalone consonants not in dictionary pass through
        $this->assertSame('x', $this->provider->transliterate('x', ScriptTypeEnum::Romaji));
        $this->assertSame('l', $this->provider->transliterate('l', ScriptTypeEnum::Romaji));
        $this->assertSame('q', $this->provider->transliterate('q', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_digits(): void
    {
        $this->assertSame('100', $this->provider->transliterate('100', ScriptTypeEnum::Romaji));
        $this->assertSame('42', $this->provider->transliterate('42', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_leading_trailing_spaces(): void
    {
        $this->assertSame(' ка ', $this->provider->transliterate(' ka ', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_multiple_spaces(): void
    {
        $this->assertSame('а  b', $this->provider->transliterate('a  b', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_punctuation(): void
    {
        $this->assertSame('а-b', $this->provider->transliterate('a-b', ScriptTypeEnum::Romaji));
        $this->assertSame('а.', $this->provider->transliterate('a.', ScriptTypeEnum::Romaji));
        $this->assertSame('(ка)', $this->provider->transliterate('(ka)', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_spaces(): void
    {
        $this->assertSame('Танака Таро', $this->provider->transliterate('Tanaka Taro', ScriptTypeEnum::Romaji));
    }

    #[Test]
    public function it_preserves_unknown_chars_in_hiragana(): void
    {
        $this->assertSame('ка1ку', $this->provider->transliterate('か1く', ScriptTypeEnum::Hiragana));
    }

    #[Test]
    public function it_preserves_unknown_chars_in_katakana(): void
    {
        $this->assertSame('ка!ко', $this->provider->transliterate('カ!コ', ScriptTypeEnum::Katakana));
    }

    // ─── Edge cases ───

    #[Test]
    public function it_returns_system_identifier(): void
    {
        $this->assertSame(TransliterationSystemEnum::Kovalenko, $this->provider->system());
    }

    #[Test]
    #[DataProvider('fullNamesProvider')]
    public function it_transliterates_full_names(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('hiraganaBasicProvider')]
    public function it_transliterates_hiragana_basic(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Hiragana));
    }

    #[Test]
    #[DataProvider('hiraganaCompoundProvider')]
    public function it_transliterates_hiragana_compounds(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Hiragana));
    }

    #[Test]
    public function it_transliterates_hiragana_words(): void
    {
        // たなか = ta-na-ka
        $this->assertSame('танака', $this->provider->transliterate('たなか', ScriptTypeEnum::Hiragana));
        // さくら = sa-ku-ra
        $this->assertSame('сакура', $this->provider->transliterate('さくら', ScriptTypeEnum::Hiragana));
    }

    #[Test]
    #[DataProvider('katakanaBasicProvider')]
    public function it_transliterates_katakana_basic(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Katakana));
    }

    #[Test]
    #[DataProvider('katakanaCompoundProvider')]
    public function it_transliterates_katakana_compounds(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Katakana));
    }

    #[Test]
    public function it_transliterates_katakana_words(): void
    {
        // タナカ = ta-na-ka
        $this->assertSame('танака', $this->provider->transliterate('タナカ', ScriptTypeEnum::Katakana));
        // サクラ = sa-ku-ra
        $this->assertSame('сакура', $this->provider->transliterate('サクラ', ScriptTypeEnum::Katakana));
    }

    #[Test]
    #[DataProvider('multiWordRomajiProvider')]
    public function it_transliterates_multi_word_romaji(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('romajiBasicSyllablesProvider')]
    public function it_transliterates_romaji_basic_syllables(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('romajiCompoundSyllablesProvider')]
    public function it_transliterates_romaji_compound_syllables(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    #[Test]
    #[DataProvider('romajiVowelsProvider')]
    public function it_transliterates_romaji_vowels(string $input, string $expected): void
    {
        $this->assertSame($expected, $this->provider->transliterate($input, ScriptTypeEnum::Romaji));
    }

    // ─── Katakana: complete coverage ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function katakanaBasicProvider(): array
    {
        return [
            // vowels
            'a' => ['ア', 'а'],
            'i' => ['イ', 'і'],
            'u' => ['ウ', 'у'],
            'e' => ['エ', 'е'],
            'o' => ['オ', 'о'],
            // ka-row
            'ka' => ['カ', 'ка'],
            'ki' => ['キ', 'кі'],
            'ku' => ['ク', 'ку'],
            'ke' => ['ケ', 'ке'],
            'ko' => ['コ', 'ко'],
            // ga-row
            'ga' => ['ガ', 'ґа'],
            'gi' => ['ギ', 'ґі'],
            'gu' => ['グ', 'ґу'],
            'ge' => ['ゲ', 'ґе'],
            'go' => ['ゴ', 'ґо'],
            // sa-row
            'sa' => ['サ', 'са'],
            'shi' => ['シ', 'ші'],
            'su' => ['ス', 'су'],
            'se' => ['セ', 'се'],
            'so' => ['ソ', 'со'],
            // za-row
            'za' => ['ザ', 'дза'],
            'ji' => ['ジ', 'джі'],
            'zu' => ['ズ', 'дзу'],
            'ze' => ['ゼ', 'дзе'],
            'zo' => ['ゾ', 'дзо'],
            // ta-row
            'ta' => ['タ', 'та'],
            'chi' => ['チ', 'чі'],
            'tsu' => ['ツ', 'цу'],
            'te' => ['テ', 'те'],
            'to' => ['ト', 'то'],
            // na-row
            'na' => ['ナ', 'на'],
            'ni' => ['ニ', 'ні'],
            'nu' => ['ヌ', 'ну'],
            'ne' => ['ネ', 'не'],
            'no' => ['ノ', 'но'],
            // ha-row
            'ha' => ['ハ', 'ха'],
            'hi' => ['ヒ', 'хі'],
            'fu' => ['フ', 'фу'],
            'he' => ['ヘ', 'хе'],
            'ho' => ['ホ', 'хо'],
            // ba-row
            'ba' => ['バ', 'ба'],
            'bi' => ['ビ', 'бі'],
            'bu' => ['ブ', 'бу'],
            'be' => ['ベ', 'бе'],
            'bo' => ['ボ', 'бо'],
            // pa-row
            'pa' => ['パ', 'па'],
            'pi' => ['ピ', 'пі'],
            'pu' => ['プ', 'пу'],
            'pe' => ['ペ', 'пе'],
            'po' => ['ポ', 'по'],
            // ma-row
            'ma' => ['マ', 'ма'],
            'mi' => ['ミ', 'мі'],
            'mu' => ['ム', 'му'],
            'me' => ['メ', 'ме'],
            'mo' => ['モ', 'мо'],
            // ya-row
            'ya' => ['ヤ', 'я'],
            'yu' => ['ユ', 'ю'],
            'yo' => ['ヨ', 'йо'],
            // ra-row
            'ra' => ['ラ', 'ра'],
            'ri' => ['リ', 'рі'],
            'ru' => ['ル', 'ру'],
            're' => ['レ', 'ре'],
            'ro' => ['ロ', 'ро'],
            // wa-row
            'wa' => ['ワ', 'ва'],
            'wo' => ['ヲ', 'о'],
            // n
            'n' => ['ン', 'н'],
            // long vowel mark
            'long vowel mark' => ['ー', ''],
        ];
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function katakanaCompoundProvider(): array
    {
        return [
            'kya' => ['キャ', 'кя'],
            'kyu' => ['キュ', 'кю'],
            'kyo' => ['キョ', 'кьо'],
            'gya' => ['ギャ', 'ґя'],
            'gyu' => ['ギュ', 'ґю'],
            'gyo' => ['ギョ', 'ґьо'],
            'sha' => ['シャ', 'шя'],
            'shu' => ['シュ', 'шю'],
            'sho' => ['ショ', 'шьо'],
            'ja' => ['ジャ', 'джя'],
            'ju' => ['ジュ', 'джю'],
            'jo' => ['ジョ', 'джьо'],
            'cha' => ['チャ', 'чя'],
            'chu' => ['チュ', 'чю'],
            'cho' => ['チョ', 'чьо'],
            'nya' => ['ニャ', 'ня'],
            'nyu' => ['ニュ', 'ню'],
            'nyo' => ['ニョ', 'ньо'],
            'hya' => ['ヒャ', 'хя'],
            'hyu' => ['ヒュ', 'хю'],
            'hyo' => ['ヒョ', 'хьо'],
            'bya' => ['ビャ', 'бя'],
            'byu' => ['ビュ', 'бю'],
            'byo' => ['ビョ', 'бьо'],
            'pya' => ['ピャ', 'пя'],
            'pyu' => ['ピュ', 'пю'],
            'pyo' => ['ピョ', 'пьо'],
            'mya' => ['ミャ', 'мя'],
            'myu' => ['ミュ', 'мю'],
            'myo' => ['ミョ', 'мьо'],
            'rya' => ['リャ', 'ря'],
            'ryu' => ['リュ', 'рю'],
            'ryo' => ['リョ', 'рьо'],
        ];
    }

    // ─── Multi-word romaji ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function multiWordRomajiProvider(): array
    {
        return [
            'two words' => ['tanaka taro', 'танака таро'],
            'three words' => ['sato kenji sama', 'сато кенджі сама'],
            'words with space between' => ['ha ru ka', 'ха ру ка'],
        ];
    }

    // ─── Special Rule 3: n → м before m/b/p ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function nAssimilationProvider(): array
    {
        return [
            'n before b' => ['shinbun', 'шімбун'],
            'n before m' => ['sanma', 'самма'],
            'n before p' => ['shinpai', 'шімпай'],
            'n before k (no assimilation)' => ['shinka', 'шінка'],
            'n before a (no assimilation)' => ['kana', 'кана'],
            'n at end (no assimilation)' => ['shin', 'шін'],
            'n before n (no assimilation)' => ['sonna', 'сонна'],
        ];
    }

    // ─── Special Rule 4: oo doubling ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function ooDoublingProvider(): array
    {
        return [
            'oo at start' => ['ookawa', 'оукава'],
            'oo in middle' => ['tooka', 'тоука'],
            'oo at end' => ['too', 'тоу'],
            'single o (no doubling)' => ['toko', 'токо'],
        ];
    }

    // ─── Romaji: Basic syllables (all rows) ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function romajiBasicSyllablesProvider(): array
    {
        return [
            // ka-row
            'ka' => ['ka', 'ка'],
            'ki' => ['ki', 'кі'],
            'ku' => ['ku', 'ку'],
            'ke' => ['ke', 'ке'],
            'ko' => ['ko', 'ко'],
            // ga-row
            'ga' => ['ga', 'ґа'],
            'gi' => ['gi', 'ґі'],
            'gu' => ['gu', 'ґу'],
            'ge' => ['ge', 'ґе'],
            'go' => ['go', 'ґо'],
            // sa-row
            'sa' => ['sa', 'са'],
            'shi' => ['shi', 'ші'],
            'su' => ['su', 'су'],
            'se' => ['se', 'се'],
            'so' => ['so', 'со'],
            // za-row
            'za' => ['za', 'дза'],
            'ji' => ['ji', 'джі'],
            'zu' => ['zu', 'дзу'],
            'ze' => ['ze', 'дзе'],
            'zo' => ['zo', 'дзо'],
            // ta-row
            'ta' => ['ta', 'та'],
            'chi' => ['chi', 'чі'],
            'tsu' => ['tsu', 'цу'],
            'te' => ['te', 'те'],
            'to' => ['to', 'то'],
            // da-row
            'da' => ['da', 'да'],
            'de' => ['de', 'де'],
            'do' => ['do', 'до'],
            // na-row
            'na' => ['na', 'на'],
            'ni' => ['ni', 'ні'],
            'nu' => ['nu', 'ну'],
            'ne' => ['ne', 'не'],
            'no' => ['no', 'но'],
            // ha-row
            'ha' => ['ha', 'ха'],
            'hi' => ['hi', 'хі'],
            'fu' => ['fu', 'фу'],
            'he' => ['he', 'хе'],
            'ho' => ['ho', 'хо'],
            // ba-row
            'ba' => ['ba', 'ба'],
            'bi' => ['bi', 'бі'],
            'bu' => ['bu', 'бу'],
            'be' => ['be', 'бе'],
            'bo' => ['bo', 'бо'],
            // pa-row
            'pa' => ['pa', 'па'],
            'pi' => ['pi', 'пі'],
            'pu' => ['pu', 'пу'],
            'pe' => ['pe', 'пе'],
            'po' => ['po', 'по'],
            // ma-row
            'ma' => ['ma', 'ма'],
            'mi' => ['mi', 'мі'],
            'mu' => ['mu', 'му'],
            'me' => ['me', 'ме'],
            'mo' => ['mo', 'мо'],
            // ya-row
            'ya' => ['ya', 'я'],
            'yu' => ['yu', 'ю'],
            'yo' => ['yo', 'йо'],
            // ra-row
            'ra' => ['ra', 'ра'],
            'ri' => ['ri', 'рі'],
            'ru' => ['ru', 'ру'],
            're' => ['re', 'ре'],
            'ro' => ['ro', 'ро'],
            // wa-row
            'wa' => ['wa', 'ва'],
            'wo' => ['wo', 'о'],
            // n
            'n' => ['n', 'н'],
        ];
    }

    // ─── Romaji: Compound syllables (all yōon) ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function romajiCompoundSyllablesProvider(): array
    {
        return [
            'kya' => ['kya', 'кя'],
            'kyu' => ['kyu', 'кю'],
            'kyo' => ['kyo', 'кьо'],
            'gya' => ['gya', 'ґя'],
            'gyu' => ['gyu', 'ґю'],
            'gyo' => ['gyo', 'ґьо'],
            'sha' => ['sha', 'шя'],
            'shu' => ['shu', 'шю'],
            'sho' => ['sho', 'шьо'],
            'ja' => ['ja', 'джя'],
            'ju' => ['ju', 'джю'],
            'jo' => ['jo', 'джьо'],
            'cha' => ['cha', 'чя'],
            'chu' => ['chu', 'чю'],
            'cho' => ['cho', 'чьо'],
            'nya' => ['nya', 'ня'],
            'nyu' => ['nyu', 'ню'],
            'nyo' => ['nyo', 'ньо'],
            'hya' => ['hya', 'хя'],
            'hyu' => ['hyu', 'хю'],
            'hyo' => ['hyo', 'хьо'],
            'bya' => ['bya', 'бя'],
            'byu' => ['byu', 'бю'],
            'byo' => ['byo', 'бьо'],
            'pya' => ['pya', 'пя'],
            'pyu' => ['pyu', 'пю'],
            'pyo' => ['pyo', 'пьо'],
            'mya' => ['mya', 'мя'],
            'myu' => ['myu', 'мю'],
            'myo' => ['myo', 'мьо'],
            'rya' => ['rya', 'ря'],
            'ryu' => ['ryu', 'рю'],
            'ryo' => ['ryo', 'рьо'],
        ];
    }

    // ─── Romaji: Vowels ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function romajiVowelsProvider(): array
    {
        return [
            'a' => ['a', 'а'],
            'i' => ['i', 'і'],
            'u' => ['u', 'у'],
            'e' => ['e', 'е'],
            'o' => ['o', 'о'],
        ];
    }

    // ─── Special Rule 1: vowel + i ───

    /**
     * @return array<string, array{string, string}>
     */
    public static function vowelPlusIProvider(): array
    {
        return [
            // Before space or end → й
            'ai at end' => ['ai', 'ай'],
            'ei at end' => ['ei', 'ей'],
            'oi at end' => ['oi', 'ой'],
            'ui at end' => ['ui', 'уй'],
            'ai before space' => ['ai no', 'ай но'],
            'ei before space' => ['mei ka', 'мей ка'],
            // Mid-word → ї
            'ai mid-word' => ['aika', 'аїка'],
            'ei mid-word' => ['meika', 'меїка'],
            'oi mid-word' => ['oiku', 'оїку'],
            'ui mid-word' => ['ruika', 'руїка'],
            // i after non-vowel should NOT trigger the rule
            'ki standalone' => ['ki', 'кі'],
            'ni standalone' => ['ni', 'ні'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new KovalenkoTransliterationProvider();
    }
}
