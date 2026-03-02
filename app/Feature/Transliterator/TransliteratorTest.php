<?php

namespace App\Feature\Transliterator;

require_once 'TransliterationService.php';

class TransliteratorTest
{
    private $failCount = 0;
    private $failures = [];
    private $persons;
    private $successCount = 0;
    private $transliterator;

    public function __construct(string $jsonFilePath)
    {
        // Ініціалізуємо транслітератор
        $this->transliterator = new TransliterationService();

        // Завантажуємо дані з JSON файлу
        $jsonContent = file_get_contents($jsonFilePath);
        $this->persons = json_decode($jsonContent, true);

        if (!$this->persons) {
            die("Помилка при завантаженні JSON файлу: " . json_last_error_msg() . "\n");
        }
    }

    public function runTest()
    {
        echo "Початок тестування транслітерації імен та прізвищ...\n";
        echo "-------------------------------------------------------\n";

        foreach ($this->persons as $person) {
            $this->testPerson($person);
        }

        $this->printResults();
    }

    private function printResults()
    {
        echo "\nРезультати тестування:\n";
        echo "-------------------------------------------------------\n";
        echo "Успішно: {$this->successCount}\n";
        echo "Невдало: {$this->failCount}\n";
        echo "Відсоток успіху: " . round(($this->successCount / ($this->successCount + $this->failCount)) * 100, 2) . "%\n";

        if ($this->failCount > 0) {
            echo "\nПриклади невдалих транслітерацій (перші 10):\n";
            echo "-------------------------------------------------------\n";

            $count = 0;
            foreach ($this->failures as $failure) {
                if ($count >= 10) {
                    break;
                }

                echo "Тип: {$failure['type']}\n";
                echo "Оригінал: {$failure['original']}\n";
                echo "Очікувано: {$failure['expected']}\n";
                echo "Отримано: {$failure['actual']}\n";
                echo "-------------------------------------------------------\n";

                $count++;
            }
        }
    }

    private function testPerson($person)
    {
        // Перевіряємо ім'я
        if (isset($person['first_name']) && isset($person['first_name_uk']) && $person['first_name']) {
            $transliterated = $this->transliterator->transliterate($person['first_name']);
            $expected = $person['first_name_uk'];

            if ($transliterated === $expected) {
                $this->successCount++;
            } else {
                $this->failCount++;
                $this->failures[] = [
                    'type' => 'ім\'я',
                    'original' => $person['first_name'],
                    'expected' => $expected,
                    'actual' => $transliterated
                ];
            }
        }

        // Перевіряємо прізвище
        if (isset($person['last_name']) && isset($person['last_name_uk']) && $person['last_name']) {
            $transliterated = $this->transliterator->transliterate($person['last_name']);
            $expected = $person['last_name_uk'];

            if ($transliterated === $expected) {
                $this->successCount++;
            } else {
                $this->failCount++;
                $this->failures[] = [
                    'type' => 'прізвище',
                    'original' => $person['last_name'],
                    'expected' => $expected,
                    'actual' => $transliterated
                ];
            }
        }
    }
}

// Використання
$tester = new TransliteratorTest('person (1).json');
$tester->runTest();
