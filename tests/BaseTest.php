<?php

declare(strict_types=1);

namespace test;

class BaseTest
{
    protected string $class;
    public int $expect;
    public string $resource = '../resource/inputTest.txt';

    public function testRun(): void
    {
        $objectReflection = new ReflectionClass($this->class);
        $object = $objectReflection->newInstanceArgs($this->resource);
        $object->run();

        if ($object->getResult() === $this->expect) {
            print_r('Success!' . '<br>');
        } else {
            print_r('FAILED' . '<br>');
        }
    }
}
