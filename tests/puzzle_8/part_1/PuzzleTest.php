<?php

declare(strict_types=1);

namespace tests\puzzle_8\part_1;

use src\puzzle_8\part_1\Puzzle;
use tests\BaseTest;

class PuzzleTest extends BaseTest
{
    public int $expect = 6;
    public string $class = Puzzle::class;
    public string $resource = __DIR__.'/../resource/inputTest.txt';
}
