<?php

declare(strict_types=1);

const DIGITS_MAP = [
    'one'   => 1,
    'two'   => 2,
    'three' => 3,
    'four'  => 4,
    'five'  => 5,
    'six'   => 6,
    'seven' => 7,
    'eight' => 8,
    'nine'  => 9,
];

$puzzleInput = '../resource/puzzle_input.txt';
$resultSum = 0;

function spelledOutToNumeric(string $digit): int
{
    return is_numeric($digit) ? (int) $digit : DIGITS_MAP[$digit];
}

function getCalibrationValue(string $inputString): string
{
    $digits = [];
    preg_match_all('/\d|one|three|four|five|six|seven/', $inputString, $matchesOne, PREG_OFFSET_CAPTURE);
    preg_match_all('/two|nine/', $inputString, $matchesTwo, PREG_OFFSET_CAPTURE);
    preg_match_all('/eight/', $inputString, $matchesThree, PREG_OFFSET_CAPTURE);

    $matches = array_merge($matchesOne[0], $matchesTwo[0], $matchesThree[0]);

    foreach ($matches as $match) {
        $digits[$match[1]] = $match[0];
    }

    ksort($digits);

    $firstDigit = spelledOutToNumeric(reset($digits));
    $lastDigit = spelledOutToNumeric(end($digits));

    return $firstDigit . $lastDigit;
}

if ($file = fopen($puzzleInput, 'r')) {
    while (($line = fgets($file)) !== false) {
        $resultSum += (int) getCalibrationValue($line);
    }

    fclose($file);
}

print_r("The sum of calibration values is: $resultSum" . '<br>' . '<br>');

print_r('TEST this puzzle'. '<br>');

function test(string $row, int $expected): void
{
    if (($res = (int) getCalibrationValue($row)) === $expected) {
        print_r("Success! $row($res) === $expected" . '<br>');
    } else {
        print_r('FAILED' . '<br>');
        print_r("res: $res, row: $row, expected: $expected" . '<br>');
    }
}

test('two1nine', 29);
test('eightwothree', 83);
test('abcone2threexyz', 13);
test('xtwone3four', 24);
test('4nineeightseven2', 42);
test('zoneight234', 14);
test('7pqrstsixteen', 76);
test('fbkmpcone555oneightkc', 18);
test('zgkjvnkczstwolctzzlsevenone6bglzxscglsnjm', 26);
test('hsbkzggsfgeight5qhblzgsppxbdlpvhvcpgkndzkjtmpggpdx', 85);
