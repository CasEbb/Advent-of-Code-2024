<?php

$lines = array_filter(explode("\n", file_get_contents("input")));
$part1 = 0;
$part2 = 0;

foreach ($lines as $line) {
    [$testValue, $numbers] = explode(':', $line);
    $testValue = (int) $testValue;
    $numbers = array_map('intval', explode(' ', trim($numbers)));
    $numOperators = count($numbers) - 1;

    foreach (part1_combinations($numOperators) as $operators) {
        if (evaluate($numbers, $operators) === $testValue) {
            $part1 += $testValue;
            break;
        }
    }

    foreach (part2_combinations($numOperators) as $operators) {
        if (evaluate($numbers, $operators) === $testValue) {
            $part2 += $testValue;
            break;
        }
    }
}

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;

function evaluate($numbers, $operators)
{
    $result = $numbers[0];
    for ($i = 0; $i < count($operators); $i++) {
        if ($operators[$i] === '+') {
            $result += $numbers[$i + 1];
        } elseif ($operators[$i] === '*') {
            $result *= $numbers[$i + 1];
        } elseif ($operators[$i] === '||') {
            $result = intval(strval($result) . strval($numbers[$i + 1]));
        }
    }
    return $result;
}

function part1_combinations($length)
{
    $combinations = [];
    $total = pow(2, $length);
    for ($i = 0; $i < $total; $i++) {
        $combination = [];
        for ($j = 0; $j < $length; $j++) {
            $combination[] = ($i & (1 << $j)) ? '*' : '+';
        }
        $combinations[] = $combination;
    }
    return $combinations;
}

function part2_combinations($length)
{
    $combinations = [];
    $total = pow(3, $length);
    for ($i = 0; $i < $total; $i++) {
        $combination = [];
        $value = $i;
        for ($j = 0; $j < $length; $j++) {
            $operator = $value % 3;
            $combination[] = $operator === 0 ? '+' : ($operator === 1 ? '*' : '||');
            $value = intdiv($value, 3);
        }
        $combinations[] = $combination;
    }
    return $combinations;
}
