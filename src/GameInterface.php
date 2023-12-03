<?php

declare(strict_types=1);

namespace src;

interface GameInterface
{
    public function run(): void;
    public function getResult(): int;
}
