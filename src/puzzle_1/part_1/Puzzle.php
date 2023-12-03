<?php

declare(strict_types=1);

namespace src\puzzle_1\part_1;

use src\BaseGame;

class Puzzle extends BaseGame
{
    public function getCalibrationValue(string $inputString): string
    {
        preg_match_all('/\d/', $inputString, $matches);
        $digits = $matches[0] ?? [];

        $firstDigit = $digits[0] ?? null;
        $lastDigit = end($digits) ?? null;

        return ($firstDigit !== null)
            ? $firstDigit . ($lastDigit !== null ? $lastDigit : $firstDigit)
            : '0';
    }

    public function run(): void
    {
        if ($file = fopen($this->puzzleInput, 'r')) {
            while (($line = fgets($file)) !== false) {
                $this->resultSum += (int) $this->getCalibrationValue($line);
            }

            fclose($file);
        }
    }
}
