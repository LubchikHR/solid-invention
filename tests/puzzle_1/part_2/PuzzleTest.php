<?php

declare(strict_types=1);

namespace tests\puzzle_1\part_2;

use src\puzzle_1\part_2\Puzzle;
use tests\BaseTest;

class PuzzleTest extends BaseTest
{
    public int $expect = 410;
    public string $class = Puzzle::class;
    public string $resource = __DIR__.'/../resource/inputTest.txt';
}
