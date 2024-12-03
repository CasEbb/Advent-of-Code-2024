<?php

$input = file_get_contents('input');

preg_match_all('/mul\((\d+),(\d+)\)|do\(\)|don\'t\(\)/', $input, $matches);

$part1 = 0;
$part2 = 0;
$enabled = true;

for ($i = 0; $i < count($matches[0]); $i++) {
    if ($matches[0][$i] == 'do()') {
        $enabled = true;
    } elseif ($matches[0][$i] == 'don\'t()') {
        $enabled = false;
    } elseif ($enabled) {
        $part1 += $matches[1][$i] * $matches[2][$i];
        $part2 += $matches[1][$i] * $matches[2][$i];
    } else {
        $part1 += $matches[1][$i] * $matches[2][$i];
    }
}

echo $part1.PHP_EOL;
echo $part2.PHP_EOL;
