<?php

declare(strict_types=1);

namespace src\puzzle_8\part_1;

use src\BaseGame;

class Puzzle extends BaseGame
{
    private array $directions = [];
    private array $instruction = [];

    public function run(): void
    {
        if ($file = fopen($this->puzzleInput, 'r')) {
            while (($line = fgets($file)) !== false) {
                if (empty($this->directions)) {
                    $this->directions = mb_str_split(substr($line, 0, -1)); //for test -2
                    continue;
                }

                if (strlen($line) < 3) continue;

                $key = substr($line, 0, 3);
                $l = substr($line, 7, 3);
                $r = substr($line, 12, 3);
                $this->instruction[$key] = [$l, $r];
            }

            fclose($file);
        }

        $this->sumIterations();
    }

    private function sumIterations(): void
    {
        $i = 0;
        $key = 'AAA';
        $this->resultSum = 0;
        $countDirections = count($this->directions);
        while ($key !== 'ZZZ') {
            $this->resultSum++;
            [$L, $R] = $this->instruction[$key];
            $key = ${$this->directions[$i]};

            $i = ($countDirections === $i + 1) ? 0 : $i+1;
        }
    }
}
