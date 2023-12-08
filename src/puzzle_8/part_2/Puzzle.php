<?php

declare(strict_types=1);

namespace src\puzzle_8\part_2;

use src\BaseGame;

class Puzzle extends BaseGame
{
    private array $directions = [];
    private array $instruction = [];
    private array $start = [];
    private array $end = [];

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

                if ('A' === substr($key, -1)) {
                    $this->start[] = $key;
                }

                if ('Z' === substr($key, -1)) {
                    $this->end[] = $key;
                }
            }

            fclose($file);
        }

        $this->sumIterations();
    }

    private function sumIterations(): void
    {
        $result = [];
        $countDirections = count($this->directions);
        foreach ($this->start as $key) {
            $i = 0;
            $iteration = 0;
            while (!in_array($key, $this->end)) {
                $iteration++;
                [$L, $R] = $this->instruction[$key];
                $key = ${$this->directions[$i]};

                $i = ($countDirections === $i + 1) ? 0 : $i+1;
            }

            $result[] = $iteration;
        }

        $prev = 0;
        foreach ($result as $countIteration) {
            if ($prev !== 0) {
                $prev = $this->lcm($prev, $countIteration);
            } else {
                $prev = $countIteration;
            }
        }

        $this->resultSum = $prev;
    }

    private function gcd($a, $b) {
        while ($b !== 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }

        return $a;
    }

    private function lcm($a, $b) {
        return ($a * $b) / $this->gcd($a, $b);
    }
}
