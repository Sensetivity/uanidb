<?php

namespace App\Services\Transliteration\Providers;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Enums\ScriptTypeEnum;
use App\Enums\TransliterationSystemEnum;

class KovalenkoTransliterationProvider implements TransliterationProvider
{
    /**
     * @var array<string, string>
     */
    private const array HIRA_UK = [
        'あ' => 'а',
        'い' => 'і',
        'う' => 'у',
        'え' => 'е',
        'お' => 'о',
        'か' => 'ка',
        'き' => 'кі',
        'く' => 'ку',
        'け' => 'ке',
        'こ' => 'ко',
        'が' => 'ґа',
        'ぎ' => 'ґі',
        'ぐ' => 'ґу',
        'げ' => 'ґе',
        'ご' => 'ґо',
        'さ' => 'са',
        'し' => 'ші',
        'す' => 'су',
        'せ' => 'се',
        'そ' => 'со',
        'ざ' => 'дза',
        'じ' => 'джі',
        'ず' => 'дзу',
        'ぜ' => 'дзе',
        'ぞ' => 'дзо',
        'た' => 'та',
        'ち' => 'чі',
        'つ' => 'цу',
        'て' => 'те',
        'と' => 'то',
        'だ' => 'да',
        'で' => 'де',
        'ど' => 'до',
        'な' => 'на',
        'に' => 'ні',
        'ぬ' => 'ну',
        'ね' => 'не',
        'の' => 'но',
        'は' => 'ха',
        'ひ' => 'хі',
        'ふ' => 'фу',
        'へ' => 'хе',
        'ほ' => 'хо',
        'ば' => 'ба',
        'び' => 'бі',
        'ぶ' => 'бу',
        'べ' => 'бе',
        'ぼ' => 'бо',
        'ぱ' => 'па',
        'ぴ' => 'пі',
        'ぷ' => 'пу',
        'ぺ' => 'пе',
        'ぽ' => 'по',
        'ま' => 'ма',
        'み' => 'мі',
        'む' => 'му',
        'め' => 'ме',
        'も' => 'мо',
        'や' => 'я',
        'ゆ' => 'ю',
        'よ' => 'йо',
        'ら' => 'ра',
        'り' => 'рі',
        'る' => 'ру',
        'れ' => 'ре',
        'ろ' => 'ро',
        'わ' => 'ва',
        'を' => 'о',
        'ん' => 'н',
        'きゃ' => 'кя',
        'きゅ' => 'кю',
        'きょ' => 'кьо',
        'ぎゃ' => 'ґя',
        'ぎゅ' => 'ґю',
        'ぎょ' => 'ґьо',
        'しゃ' => 'шя',
        'しゅ' => 'шю',
        'しょ' => 'шьо',
        'じゃ' => 'джя',
        'じゅ' => 'джю',
        'じょ' => 'джьо',
        'ちゃ' => 'чя',
        'ちゅ' => 'чю',
        'ちょ' => 'чьо',
        'にゃ' => 'ня',
        'にゅ' => 'ню',
        'にょ' => 'ньо',
        'ひゃ' => 'хя',
        'ひゅ' => 'хю',
        'ひょ' => 'хьо',
        'びゃ' => 'бя',
        'びゅ' => 'бю',
        'びょ' => 'бьо',
        'ぴゃ' => 'пя',
        'ぴゅ' => 'пю',
        'ぴょ' => 'пьо',
        'みゃ' => 'мя',
        'みゅ' => 'мю',
        'みょ' => 'мьо',
        'りゃ' => 'ря',
        'りゅ' => 'рю',
        'りょ' => 'рьо',
    ];

    /**
     * @var array<string, string>
     */
    private const array KANA_UK = [
        'ア' => 'а',
        'イ' => 'і',
        'ウ' => 'у',
        'エ' => 'е',
        'オ' => 'о',
        'カ' => 'ка',
        'キ' => 'кі',
        'ク' => 'ку',
        'ケ' => 'ке',
        'コ' => 'ко',
        'ガ' => 'ґа',
        'ギ' => 'ґі',
        'グ' => 'ґу',
        'ゲ' => 'ґе',
        'ゴ' => 'ґо',
        'サ' => 'са',
        'シ' => 'ші',
        'ス' => 'су',
        'セ' => 'се',
        'ソ' => 'со',
        'ザ' => 'дза',
        'ジ' => 'джі',
        'ズ' => 'дзу',
        'ゼ' => 'дзе',
        'ゾ' => 'дзо',
        'タ' => 'та',
        'チ' => 'чі',
        'ツ' => 'цу',
        'テ' => 'те',
        'ト' => 'то',
        'ダ' => 'да',
        'ヂ' => 'джі',
        'ヅ' => 'дзу',
        'デ' => 'де',
        'ド' => 'до',
        'ナ' => 'на',
        'ニ' => 'ні',
        'ヌ' => 'ну',
        'ネ' => 'не',
        'ノ' => 'но',
        'ハ' => 'ха',
        'ヒ' => 'хі',
        'フ' => 'фу',
        'ヘ' => 'хе',
        'ホ' => 'хо',
        'バ' => 'ба',
        'ビ' => 'бі',
        'ブ' => 'бу',
        'ベ' => 'бе',
        'ボ' => 'бо',
        'パ' => 'па',
        'ピ' => 'пі',
        'プ' => 'пу',
        'ペ' => 'пе',
        'ポ' => 'по',
        'マ' => 'ма',
        'ミ' => 'мі',
        'ム' => 'му',
        'メ' => 'ме',
        'モ' => 'мо',
        'ヤ' => 'я',
        'ユ' => 'ю',
        'ヨ' => 'йо',
        'ラ' => 'ра',
        'リ' => 'рі',
        'ル' => 'ру',
        'レ' => 'ре',
        'ロ' => 'ро',
        'ワ' => 'ва',
        'ヲ' => 'о',
        'ン' => 'н',
        'キャ' => 'кя',
        'キュ' => 'кю',
        'キョ' => 'кьо',
        'ギャ' => 'ґя',
        'ギュ' => 'ґю',
        'ギョ' => 'ґьо',
        'シャ' => 'шя',
        'シュ' => 'шю',
        'ショ' => 'шьо',
        'ジャ' => 'джя',
        'ジュ' => 'джю',
        'ジョ' => 'джьо',
        'チャ' => 'чя',
        'チュ' => 'чю',
        'チョ' => 'чьо',
        'ニャ' => 'ня',
        'ニュ' => 'ню',
        'ニョ' => 'ньо',
        'ヒャ' => 'хя',
        'ヒュ' => 'хю',
        'ヒョ' => 'хьо',
        'ビャ' => 'бя',
        'ビュ' => 'бю',
        'ビョ' => 'бьо',
        'ピャ' => 'пя',
        'ピュ' => 'пю',
        'ピョ' => 'пьо',
        'ミャ' => 'мя',
        'ミュ' => 'мю',
        'ミョ' => 'мьо',
        'リャ' => 'ря',
        'リュ' => 'рю',
        'リョ' => 'рьо',
        'ー' => '',
    ];

    /**
     * @var array<string, string>
     */
    private const array ROMAJI_UK = [
        'a' => 'а',
        'i' => 'і',
        'u' => 'у',
        'e' => 'е',
        'o' => 'о',
        'ka' => 'ка',
        'ki' => 'кі',
        'ku' => 'ку',
        'ke' => 'ке',
        'ko' => 'ко',
        'ga' => 'ґа',
        'gi' => 'ґі',
        'gu' => 'ґу',
        'ge' => 'ґе',
        'go' => 'ґо',
        'sa' => 'са',
        'shi' => 'ші',
        'su' => 'су',
        'se' => 'се',
        'so' => 'со',
        'za' => 'дза',
        'ji' => 'джі',
        'zu' => 'дзу',
        'ze' => 'дзе',
        'zo' => 'дзо',
        'ta' => 'та',
        'chi' => 'чі',
        'tsu' => 'цу',
        'te' => 'те',
        'to' => 'то',
        'da' => 'да',
        'de' => 'де',
        'do' => 'до',
        'na' => 'на',
        'ni' => 'ні',
        'nu' => 'ну',
        'ne' => 'не',
        'no' => 'но',
        'ha' => 'ха',
        'hi' => 'хі',
        'fu' => 'фу',
        'he' => 'хе',
        'ho' => 'хо',
        'ba' => 'ба',
        'bi' => 'бі',
        'bu' => 'бу',
        'be' => 'бе',
        'bo' => 'бо',
        'pa' => 'па',
        'pi' => 'пі',
        'pu' => 'пу',
        'pe' => 'пе',
        'po' => 'по',
        'ma' => 'ма',
        'mi' => 'мі',
        'mu' => 'му',
        'me' => 'ме',
        'mo' => 'мо',
        'ya' => 'я',
        'yu' => 'ю',
        'yo' => 'йо',
        'ra' => 'ра',
        'ri' => 'рі',
        'ru' => 'ру',
        're' => 'ре',
        'ro' => 'ро',
        'wa' => 'ва',
        'wo' => 'о',
        'n' => 'н',
        'kya' => 'кя',
        'kyu' => 'кю',
        'kyo' => 'кьо',
        'gya' => 'ґя',
        'gyu' => 'ґю',
        'gyo' => 'ґьо',
        'sha' => 'шя',
        'shu' => 'шю',
        'sho' => 'шьо',
        'ja' => 'джя',
        'ju' => 'джю',
        'jo' => 'джьо',
        'cha' => 'чя',
        'chu' => 'чю',
        'cho' => 'чьо',
        'nya' => 'ня',
        'nyu' => 'ню',
        'nyo' => 'ньо',
        'hya' => 'хя',
        'hyu' => 'хю',
        'hyo' => 'хьо',
        'bya' => 'бя',
        'byu' => 'бю',
        'byo' => 'бьо',
        'pya' => 'пя',
        'pyu' => 'пю',
        'pyo' => 'пьо',
        'mya' => 'мя',
        'myu' => 'мю',
        'myo' => 'мьо',
        'rya' => 'ря',
        'ryu' => 'рю',
        'ryo' => 'рьо',
    ];

    private const array VOWELS = ['a', 'i', 'u', 'e', 'o'];

    public function system(): TransliterationSystemEnum
    {
        return TransliterationSystemEnum::Kovalenko;
    }

    public function transliterate(string $text, ScriptTypeEnum $script): string
    {
        return match ($script) {
            ScriptTypeEnum::Romaji => $this->transliterateRomaji($text),
            ScriptTypeEnum::Hiragana => $this->transliterateKana($text, self::HIRA_UK),
            ScriptTypeEnum::Katakana => $this->transliterateKana($text, self::KANA_UK),
        };
    }

    /**
     * Apply capitalization from original text to the transliterated output.
     * If the original character is uppercase, capitalize the first letter of the result.
     */
    private function applyCapitalization(string $originalText, int $position, string $transliterated): string
    {
        $originalChar = mb_substr($originalText, $position, 1);

        if ($originalChar === mb_strtoupper($originalChar) && $originalChar !== mb_strtolower($originalChar)) {
            return mb_strtoupper(mb_substr($transliterated, 0, 1)) . mb_substr($transliterated, 1);
        }

        return $transliterated;
    }

    /**
     * Transliterate hiragana/katakana text to Ukrainian.
     * Uses longest-match-first (max 2 chars for kana compound syllables).
     *
     * @param  array<string, string>  $dictionary
     */
    private function transliterateKana(string $text, array $dictionary): string
    {
        $result = '';
        $i = 0;
        $length = mb_strlen($text);

        while ($i < $length) {
            $char = mb_substr($text, $i, 1);

            if ($char === ' ') {
                $result .= ' ';
                $i++;

                continue;
            }

            $matched = false;
            $checkLen = min(2, $length - $i);

            while ($checkLen > 0) {
                $chunk = mb_substr($text, $i, $checkLen);

                if (isset($dictionary[$chunk])) {
                    $result .= $dictionary[$chunk];
                    $i += $checkLen;
                    $matched = true;

                    break;
                }

                $checkLen--;
            }

            if (! $matched) {
                $result .= $char;
                $i++;
            }
        }

        return $result;
    }

    /**
     * Transliterate romaji text to Ukrainian using Kovalenko (2012) rules.
     *
     * Algorithm: longest-match-first (max 3 chars) with 5 special rules:
     * 1. vowel + i → й (before space/end) or ї (mid-word)
     * 2. ie → є (i followed by e)
     * 3. n → м before m/b/p (assimilation)
     * 4. oo → doubled vowel (о + у)
     * 5. ee → extended (е + і)
     */
    private function transliterateRomaji(string $text): string
    {
        $lower = mb_strtolower($text);
        $result = '';
        $i = 0;
        $length = mb_strlen($lower);

        while ($i < $length) {
            $char = mb_substr($lower, $i, 1);

            if ($char === ' ') {
                $result .= ' ';
                $i++;

                continue;
            }

            $matched = false;
            $checkLen = min(3, $length - $i);

            while ($checkLen > 0) {
                $chunk = mb_substr($lower, $i, $checkLen);

                if (isset(self::ROMAJI_UK[$chunk])) {
                    $prevChar = $i > 0 ? mb_substr($lower, $i - 1, 1) : '';
                    $nextChar = ($i + $checkLen) < $length ? mb_substr($lower, $i + $checkLen, 1) : '';

                    // Rule 1: vowel + i → й (before space/end) or ї (mid-word)
                    if ($chunk === 'i' && in_array($prevChar, self::VOWELS, true)) {
                        $result .= ($nextChar === ' ' || $nextChar === '') ? 'й' : 'ї';
                    }
                    // Rule 2: ie → є
                    elseif ($chunk === 'e' && $prevChar === 'i') {
                        $result .= 'є';
                    }
                    // Rule 3: n → м before m/b/p
                    elseif ($chunk === 'n' && in_array($nextChar, ['m', 'b', 'p'], true)) {
                        $result .= 'м';
                    } else {
                        $result .= $this->applyCapitalization($text, $i, self::ROMAJI_UK[$chunk]);
                    }

                    $i += $checkLen;

                    // Rule 4: oo doubling → append у
                    if ($i < $length && mb_substr($lower, $i, 1) === 'o' && mb_substr($lower, $i - 1, 1) === 'o') {
                        $result .= self::ROMAJI_UK['u'];
                        $i++;
                    }
                    // Rule 5: ee doubling → append і
                    elseif ($i < $length && mb_substr($lower, $i, 1) === 'e' && mb_substr($lower, $i - 1, 1) === 'e') {
                        $result .= self::ROMAJI_UK['i'];
                        $i++;
                    }

                    $matched = true;

                    break;
                }

                $checkLen--;
            }

            if (! $matched) {
                $result .= $this->applyCapitalization($text, $i, mb_substr($text, $i, 1));
                $i++;
            }
        }

        return $result;
    }
}
