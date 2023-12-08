<?php

declare(strict_types=1);

namespace src\puzzle_3\part_2;

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
        $temporaryNumbers = [];
        $temporaryStars = [];
        foreach ($this->matrix as $verticalIndex => $row) {
            $concatenatedNumber = '';
            $numberPosition = [];
            foreach ($row as $horizonIndex => $value) {
                if ($value === '*') {
                    $temporaryStars[$verticalIndex][] = $horizonIndex;
                }

                if (is_numeric($value)) {
                    $concatenatedNumber .= $value;
                    $numberPosition[] = $horizonIndex;
                } else {
                    if ('' !== $concatenatedNumber && !empty($numberPosition)) {
                        $temporaryNumbers[$verticalIndex][] =[(int) $concatenatedNumber => $numberPosition];

                        $concatenatedNumber = '';
                        $numberPosition = [];
                    }
                }
            }

            if ('' !== $concatenatedNumber && !empty($numberPosition)) {
                $temporaryNumbers[$verticalIndex][] = [(int) $concatenatedNumber => $numberPosition];
            }
        }

        $this->resultSum = $this->calculateNumbersByStar($temporaryNumbers, $temporaryStars);
    }

    public function calculateNumbersByStar(array &$numbers, array &$stars): int
    {
        $numbersSum = [];
        $directions = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],           [0, 1],
            [1, -1],  [1, 0],  [1, 1],
        ];

        foreach ($stars as $verticalIndex => $positions) {
            foreach ($positions as $position) {
                foreach ($directions as $dir) {
                    $newX = $position + $dir[1];
                    $newY = $verticalIndex + $dir[0];

                    if ($num = $this->findNumbersByStarPosition($numbers[$newY] ?? [], $newX)) {
                        if (!isset($numbersSum[$verticalIndex][$position]) || !in_array($num, $numbersSum[$verticalIndex][$position])) {
                            $numbersSum[$verticalIndex][$position][] = $num;
                        }
                    }
                }
            }

            $numbersSum[$verticalIndex] = array_sum(
                array_map(fn($arr) => count($arr) > 1 ? $arr[0] * $arr[1] : 0, $numbersSum[$verticalIndex])
            );
        }

        return array_sum($numbersSum);
    }

    public function findNumbersByStarPosition(array $numbers, int $starPosition): ?int
    {
        foreach ($numbers as $positions) {
            $number = key($positions);

            if (in_array($starPosition, array_values($positions[$number]), true)) {
                return $number;
            }
        }

        return null;
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
