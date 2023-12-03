<?php

declare(strict_types=1);

namespace src;

abstract class BaseGame implements GameInterface
{
    protected string $puzzleInput;
    protected int $resultSum = 0;

    public function __construct(string $puzzleInput)
    {
        $this->puzzleInput = $puzzleInput;
    }

    public function getResult(): int
    {
        return $this->resultSum;
    }
}
