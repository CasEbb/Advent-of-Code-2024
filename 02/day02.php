<?php

function isIncreasing(array $arr): bool {
    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] <= $arr[$i - 1] || abs($arr[$i] - $arr[$i - 1]) > 3) {
            return false;
        }
    }

    return true;
}

function isDecreasing(array $arr): bool {
    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] >= $arr[$i - 1] || abs($arr[$i] - $arr[$i - 1]) > 3) {
            return false;
        }
    }

    return true;
}

$safe = 0;
$problemDampenerSafe = 0;

foreach (file('input') as $line) {
    $levels = explode(' ', trim($line));

    if (isIncreasing($levels) || isDecreasing($levels)) {
        $safe++;
    }

    for ($i = 0; $i < count($levels); $i++) {
        $levelsMinusOne = $levels;
        unset($levelsMinusOne[$i]);
        $levelsMinusOne = array_values($levelsMinusOne);

        if (isIncreasing($levelsMinusOne) || isDecreasing($levelsMinusOne)) {
            $problemDampenerSafe++;
            break;
        }
    }
}

echo $safe.PHP_EOL;
echo $problemDampenerSafe.PHP_EOL;
