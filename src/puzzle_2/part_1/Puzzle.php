<?php

declare(strict_types=1);

namespace src\puzzle_2\part_1;

use src\BaseGame;

class Puzzle extends BaseGame
{
    private const CONDITION = [
        'red'   => 12,
        'green' => 13,
        'blue'  => 14,
    ];

    protected function isPossibleGame(string $line): bool
    {
        $game = explode(': ', $line);
        foreach (explode('; ', end($game)) as $setsOfCubes) {
            foreach (explode(', ', $setsOfCubes) as $cubes) {
                if (!$this->checkCondition(...explode(' ', $cubes))) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function checkCondition(string $cubeCount, string $cubeColor): bool
    {
        return self::CONDITION[trim($cubeColor)] >= (int) $cubeCount;
    }

    public function run(): void
    {
        if ($file = fopen($this->puzzleInput, 'r')) {
            $gameId = 1;
            while (($line = fgets($file)) !== false) {
                if ($this->isPossibleGame($line)) {
                    $this->resultSum += $gameId;
                }
                $gameId++;
            }

            fclose($file);
        }
    }
}
