<?php

$left = [];
$right = [];

foreach (file('./input') as $line) {
    $numbers = explode('   ', trim($line));
    $left[] = $numbers[0];
    $right[] = $numbers[1];
}

sort($left);
sort($right);
$distance = 0;
$similarity = 0;

foreach ($left as $i => $leftVal) {
    $distance += abs($leftVal - $right[$i]);

    $count = count(array_filter($right, fn ($rightVal) => $rightVal == $leftVal));
    $similarity += $leftVal * $count;
}

echo $distance.PHP_EOL;
echo $similarity.PHP_EOL;
