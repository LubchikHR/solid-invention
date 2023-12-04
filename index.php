<?php

declare(strict_types=1);

require_once(__DIR__.'/vendor/autoload.php');

const LINK_INPUT_MASK = '/resource/puzzle_%s/input.txt';
const PUZZLE_CLASS_MASK = 'src\\puzzle_%s\\part_%s\\Puzzle';
const PUZZLE_TEST_CLASS_MASK = 'tests\\puzzle_%s\\part_%s\\PuzzleTest';

set_include_path(__DIR__);

spl_autoload_register(function ($className) {
    $fileName = get_include_path()."/".$className . '.php';
    $fileName = str_replace("\\", "/", $fileName);

    if (file_exists($fileName)) {
        require_once($fileName);
    } else {
        echo "File not found";
    }
});

$class = isset($_GET['test']) ? PUZZLE_TEST_CLASS_MASK : PUZZLE_CLASS_MASK;
$loadedClass = sprintf($class, $_GET['puzzle'], $_GET['part']);

if (file_exists($loadedClass . '.php')) {
    $objectReflection = new ReflectionClass($loadedClass);

    if (isset($_GET['test'])) {
        ($objectReflection->newInstanceArgs())->run();
    } else {
        /** @var \src\GameInterface $object */
        $object = $objectReflection->newInstanceArgs([
            sprintf(__DIR__.LINK_INPUT_MASK, $_GET['puzzle'])
        ]);

        $object->run();

        print_r("Result number is: " . $object->getResult() . '<br>' . '<br>');
    }
} else {
    print_r('<div style="color: red">This puzzle doesn`t exist</div>');
}
