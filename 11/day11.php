<?php

$stones = trim(file_get_contents("input"));
$stones = array_map('intval', explode(" ", $stones));

$part1 = array_sum(
    array_map(fn($stone) => blink($stone, 25), $stones),
);

$part2 = array_sum(
    array_map(fn($stone) => blink($stone, 75), $stones),
);

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;

function blink(int $value, $stepsLeft)
{
    static $cache = [];

    if (isset($cache[$value][$stepsLeft])) return $cache[$value][$stepsLeft];

    if ($stepsLeft === 0) return 1;

    if ($value === 0) {
        $newValue = blink(1, $stepsLeft - 1);
    } elseif (strlen($value) % 2 === 0) {
        [$left, $right] = str_split($value, strlen($value) / 2);
        $newValue = blink($left, $stepsLeft - 1) + blink($right, $stepsLeft - 1);
    } else {
        $newValue = blink($value * 2024, $stepsLeft - 1);
    }

    return $cache[$value][$stepsLeft] = $newValue;
}
