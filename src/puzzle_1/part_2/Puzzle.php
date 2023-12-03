<?php

declare(strict_types=1);

namespace src\puzzle_1\part_2;

use src\BaseGame;

class Puzzle extends BaseGame
{
    private const DIGITS_MAP = [
        'one'   => 1,
        'two'   => 2,
        'three' => 3,
        'four'  => 4,
        'five'  => 5,
        'six'   => 6,
        'seven' => 7,
        'eight' => 8,
        'nine'  => 9,
    ];

    protected function spelledOutToNumeric(string $digit): int
    {
        return is_numeric($digit) ? (int)$digit : self::DIGITS_MAP[$digit];
    }

    protected function getCalibrationValue(string $inputString): string
    {
        $digits = [];
        preg_match_all('/\d|one|three|four|five|six|seven/', $inputString, $matchesOne, PREG_OFFSET_CAPTURE);
        preg_match_all('/two|nine/', $inputString, $matchesTwo, PREG_OFFSET_CAPTURE);
        preg_match_all('/eight/', $inputString, $matchesThree, PREG_OFFSET_CAPTURE);

        $matches = array_merge($matchesOne[0], $matchesTwo[0], $matchesThree[0]);

        foreach ($matches as $match) {
            $digits[$match[1]] = $match[0];
        }

        ksort($digits);

        $firstDigit = $this->spelledOutToNumeric(reset($digits));
        $lastDigit = $this->spelledOutToNumeric(end($digits));

        return $firstDigit.$lastDigit;
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
