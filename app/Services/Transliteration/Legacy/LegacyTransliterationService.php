<?php

namespace App\Services\Transliteration\Legacy;

class LegacyTransliterationService
{
    private array $currentMap;
    private array $maps;

    public function __construct()
    {
        $this->maps = require __DIR__ . '/mapping.php';
        $this->currentMap = $this->maps['r2ua'];
    }

    /**
     * Set the transliteration mapping.
     */
    public function setMap(string $map, bool $useVariants = false): self
    {
        $mapName = $map . ($useVariants ? 'v' : '');

        if (! isset($this->maps[$mapName])) {
            throw new \InvalidArgumentException("Transliteration map '{$mapName}' does not exist.");
        }

        $this->currentMap = $this->maps[$mapName];

        return $this;
    }

    /**
     * Transliterate text using the current mapping.
     */
    public function transliterate(string $text): string
    {
        return $this->traverse(0, $text, $this->currentMap, true);
    }

    /**
     * Recursively traverse the text and apply the transliteration mapping.
     */
    private function traverse(int $index, string $text, array $chars, bool $isWhitespace = false): string
    {
        if ($index >= mb_strlen($text)) {
            return '';
        }

        $char = mb_substr($text, $index, 1);

        if (isset($chars[$char])) {
            $value = $chars[$char];

            if (is_array($value) && isset($value[0])) {
                return ($isWhitespace ? $value[1] : $value[0]) .
                    $this->traverse($index + 1, $text, $this->currentMap);
            } elseif (is_array($value)) {
                $nextIndex = $index + 1;
                if ($nextIndex < mb_strlen($text)) {
                    $nextChar = mb_substr($text, $nextIndex, 1);

                    if (isset($value[$nextChar])) {
                        return $this->traverse($nextIndex, $text, $value, $isWhitespace);
                    }
                }

                if (isset($value['~'])) {
                    $defaultValue = $value['~'];
                    if (is_array($defaultValue) && isset($defaultValue[0])) {
                        return ($isWhitespace ? $defaultValue[1] : $defaultValue[0]) .
                            $this->traverse($index + 1, $text, $this->currentMap);
                    } else {
                        return $defaultValue . $this->traverse($index + 1, $text, $this->currentMap);
                    }
                }

                return $char . $this->traverse($index + 1, $text, $this->currentMap, $char === ' ');
            } else {
                return $value . $this->traverse($index + 1, $text, $this->currentMap);
            }
        } elseif (isset($chars['~'])) {
            $value = $chars['~'];

            if (is_array($value) && isset($value[0])) {
                return ($isWhitespace ? $value[1] : $value[0]) .
                    $this->traverse($index + 1, $text, $this->currentMap);
            } else {
                return $value . $this->traverse($index + 1, $text, $this->currentMap);
            }
        } elseif ($char) {
            return $char . $this->traverse($index + 1, $text, $this->currentMap, $char === ' ');
        }

        return '';
    }
}
