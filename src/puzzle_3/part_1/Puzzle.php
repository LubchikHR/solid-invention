<?php

declare(strict_types=1);

namespace src\puzzle_3\part_1;

use src\BaseGame;

class Puzzle extends BaseGame
{
    private array $matrix = [];

    public function run(): void
    {
        $this->loadFileIntoMatrix();
        $this->calculateNumbers();
    }

    private function calculateNumbers(): void
    {
        foreach ($this->matrix as $verticalIndex => $row) {
            $concatenatedNumber = '';
            $latestHorizonIndex = 0;
            foreach ($row as $horizonIndex => $value) {
                if (is_numeric($value)) {
                    $concatenatedNumber .= $value;
                } else {
                    if ('' !== $concatenatedNumber
                        && (
                            $this->isSpecialChar($value)
                            || $this->isAdjacentToSymbol($verticalIndex, $horizonIndex, $concatenatedNumber)
                        )
                    ) {
                        $this->resultSum += (int) $concatenatedNumber;
                    }

                    $concatenatedNumber = '';
                }

                $latestHorizonIndex = $horizonIndex;
            }

            if ('' !== $concatenatedNumber && $this->isAdjacentToSymbol($verticalIndex, $latestHorizonIndex, $concatenatedNumber, true)) {
                $this->resultSum += (int) $concatenatedNumber;
            }
        }
    }

    private function isAdjacentToSymbol(int $verticalIndex, int $horizonIndex, string $number, bool $latest = false): bool
    {
        $numberLength = strlen($number);

        $horizonStart = ($latest)
            ? $horizonIndex - $numberLength
            : $horizonIndex - $numberLength - 1;
        $horizonStart = max(0, $horizonStart);

        if ($this->isSpecialChar($this->matrix[$verticalIndex][$horizonStart])) {
            return true;
        }

        $h = $horizonStart;
        $v = isset($this->matrix[$verticalIndex - 1]) ? $verticalIndex - 1 : $verticalIndex + 1;

        while ($v - $verticalIndex < 2) {
            if (!isset($this->matrix[$v][$h])) {
                break;
            }

            if ($this->isSpecialChar($this->matrix[$v][$h])) {
                return true;
            }

            if ($h === $horizonIndex) {
                $h = $horizonStart;
                $v += 2;
            } else {
                $h++;
            }
        }

        return false;
    }

    private function isSpecialChar(string $char): bool
    {
        return $char !== '.' && !is_numeric($char);
    }

    private function loadFileIntoMatrix(): void
    {
        if ($file = fopen($this->puzzleInput, 'r')) {
            $i = 0;
            while (($line = fgets($file)) !== false) {
                foreach (mb_str_split($line) as $char) {
                    if ($char === "\n") {
                        continue;
                    }

                    $this->matrix[$i][] = $char;
                }
                $i++;
            }

            fclose($file);
        }
    }
}
