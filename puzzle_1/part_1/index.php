<?php

$puzzleInput = '../resource/puzzle_input.txt';
$resultSum = 0;

function getCalibrationValue(string $inputString): int
{
    preg_match_all('/\d/', $inputString, $matches);
    $digits = $matches[0] ?? [];

    $firstDigit = $digits[0] ?? null;
    $lastDigit = end($digits) ?? null;

    return ($firstDigit !== null)
        ? $firstDigit . ($lastDigit !== null ? $lastDigit : $firstDigit)
        : 0;
}

if ($file = fopen($puzzleInput, 'r')) {
    while (($line = fgets($file)) !== false) {
        $resultSum += getCalibrationValue($line);
    }

    fclose($file);
}

print_r("The sum of calibration values is: $resultSum" . '<br>' . '<br>');

print_r('TEST this puzzle'. '<br>');

function test(string $row, int $expected): void
{
    if (getCalibrationValue($row) === $expected) {
        print_r("Success! $row === $expected" . '<br>');
    } else {
        print_r('FAILED' . '<br>');
        print_r("row: $row, expected: $expected" . '<br>');
    }
}

test('1abc2', 12);
test('pqr3stu8vwx', 38);
test('a1b2c3d4e5f', 15);
test('treb7uchet', 77);
