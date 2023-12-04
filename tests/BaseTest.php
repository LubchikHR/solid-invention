<?php

declare(strict_types=1);

namespace tests;

class BaseTest
{
    protected string $class;
    public int $expect;
    public string $resource;

    public function run(): void
    {
        $objectReflection = new \ReflectionClass($this->class);
        /** @var \src\GameInterface $object */
        $object = $objectReflection->newInstanceArgs([$this->resource]);
        $object->run();

        if ($object->getResult() === $this->expect) {
            print_r('Success!' . '<br>');
        } else {
            print_r('FAILED' . '<br>');
        }
    }
}
