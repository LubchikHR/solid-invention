<?php

declare(strict_types=1);

const LINK_INPUT_MASK = '/resource/puzzle_%s/input.txt';
const PUZZLES = [
    11 => src\puzzle_1\part_1\Puzzle::class,
    12 => src\puzzle_1\part_2\Puzzle::class,
    21 => src\puzzle_2\part_1\Puzzle::class,
    22 => src\puzzle_2\part_2\Puzzle::class,
];

set_include_path(__DIR__);

spl_autoload_register(function ($className) {
    $fileName = get_include_path()."/".$className . '.php';
    $fileName = str_replace("\\", "/", $fileName);

    if (file_exists($fileName)) {
        require_once($fileName);
    } else {
        echo "file not found";
    }
});

if (isset(PUZZLES[$_GET['puzzle'] . $_GET['part']])) {
    $className = (isset($_GET['test']))
        ? PUZZLES[$_GET['puzzle'] . $_GET['part']].'Test'
        : PUZZLES[$_GET['puzzle'] . $_GET['part']];

    $objectReflection = new ReflectionClass($className);
    /** @var \src\GameInterface $object */
    $object = $objectReflection->newInstanceArgs([sprintf(__DIR__.LINK_INPUT_MASK, $_GET['puzzle'])]);
} else {
    print_r('<div style="color: red">This puzzle doesn`t exist</div>');
}

if(isset($_GET['test'])) {
    $object->testRun();
} else {
    $object->run();
}

print_r("Result number is: " . $object->getResult() . '<br>' . '<br>');
