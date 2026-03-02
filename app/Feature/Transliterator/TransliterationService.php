<?php

namespace App\Feature\Transliterator;

class TransliterationService
{
    private array $currentMap;
    private array $maps;

    public function __construct()
    {
        // Load the mapping dictionaries
        $this->maps = require 'mapping.php';

        // Set default mapping
        $this->currentMap = $this->maps['r2ua'];
    }

    /**
     * Set the transliteration mapping
     */
    public function setMap(string $map, bool $useVariants = false): self
    {
        $mapName = $map . ($useVariants ? 'v' : '');

        if (!isset($this->maps[$mapName])) {
            throw new \InvalidArgumentException("Transliteration map '{$mapName}' does not exist.");
        }

        $this->currentMap = $this->maps[$mapName];

        return $this;
    }

    /**
     * Transliterate text using the current mapping
     */
    public function transliterate(string $text): string
    {
        return $this->traverse(0, $text, $this->currentMap, true);
    }

    /**
     * Recursively traverse the text and apply the transliteration mapping
     *
     * Fixed version to correctly handle nested maps and avoid skipping the last character
     */
    private function traverse(int $index, string $text, array $chars, bool $isWhitespace = false): string
    {
        // End of text
        if ($index >= mb_strlen($text)) {
            return '';
        }

        $char = mb_substr($text, $index, 1);

        if (isset($chars[$char])) {
            $value = $chars[$char];

            if (is_array($value) && isset($value[0])) {
                // If value is a sequential array, select element based on whitespace
                return ($isWhitespace ? $value[1] : $value[0]) .
                    $this->traverse($index + 1, $text, $this->currentMap);
            } elseif (is_array($value)) {
                // If value is an associative array, check if next character exists in it
                $nextIndex = $index + 1;
                if ($nextIndex < mb_strlen($text)) {
                    $nextChar = mb_substr($text, $nextIndex, 1);

                    // If next character is in the nested map, use nested map
                    if (isset($value[$nextChar])) {
                        return $this->traverse($nextIndex, $text, $value, $isWhitespace);
                    }
                }

                // If not found in nested map or no next character, use default value if available
                if (isset($value['~'])) {
                    $defaultValue = $value['~'];
                    if (is_array($defaultValue) && isset($defaultValue[0])) {
                        return ($isWhitespace ? $defaultValue[1] : $defaultValue[0]) .
                            $this->traverse($index + 1, $text, $this->currentMap);
                    } else {
                        return $defaultValue . $this->traverse($index + 1, $text, $this->currentMap);
                    }
                }

                // No mapping found for next character in nested map and no default,
                // just process current character and continue with main map
                return $char . $this->traverse($index + 1, $text, $this->currentMap, $char === ' ');
            } else {
                // If value is a string, use it directly
                return $value . $this->traverse($index + 1, $text, $this->currentMap);
            }
        } elseif (isset($chars['~'])) {
            // Default mapping for this level
            $value = $chars['~'];

            if (is_array($value) && isset($value[0])) {
                return ($isWhitespace ? $value[1] : $value[0]) .
                    $this->traverse($index + 1, $text, $this->currentMap);
            } else {
                return $value . $this->traverse($index + 1, $text, $this->currentMap);
            }
        } elseif ($char) {
            // No mapping found, keep character as is
            return $char . $this->traverse($index + 1, $text, $this->currentMap, $char === ' ');
        }

        return '';
    }
}
