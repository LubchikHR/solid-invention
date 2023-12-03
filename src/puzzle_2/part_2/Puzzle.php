<?php

declare(strict_types=1);

namespace src\puzzle_2\part_2;

use src\BaseGame;

class Puzzle extends BaseGame
{
    protected function calculatePossibleGames(string $line): bool
    {
        $gameResult = 1;
        $gameValues = [];

        $game = explode(': ', $line);
        foreach (explode('; ', end($game)) as $setsOfCubes) {
            foreach (explode(', ', $setsOfCubes) as $cubes) {
                $res = explode(' ', $cubes);

                $count = (int) reset($res);
                $color = trim(end($res));

                $gameValues[$color][] = $count;
            }
        }

        foreach ($gameValues as $color => $values) {
            $gameResult *= max($values);
        }

        $this->resultSum += $gameResult;

        return true;
    }

    public function run(): void
    {
        if ($file = fopen($this->puzzleInput, 'r')) {
            while (($line = fgets($file)) !== false) {
                $this->calculatePossibleGames($line);
            }

            fclose($file);
        }
    }
}
