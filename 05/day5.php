<?php

function all_rules_hold($rules, $update)
{
    return array_all($rules, function ($rule) use ($update) {
        $pos1 = array_search($rule[0], $update);
        $pos2 = array_search($rule[1], $update);

        return ! ($pos1 && $pos2 && $pos2 < $pos1);
    });
}

function rule_sort($rules, &$update)
{
    usort($update, function ($a, $b) use ($rules) {
        foreach ($rules as $rule) {
            if ($rule[0] == $a && $rule[1] == $b) return -1;
            if ($rule[0] == $b && $rule[1] == $a) return 1;
        }

        return 0;
    });
}

[$rules, $updates] = explode("\n\n", file_get_contents('input'));
$rules = array_map(
    fn($rule) => array_map('intval', explode('|', $rule)),
    explode("\n", $rules),
);
$updates = array_map(
    fn($update) => array_map('intval', explode(",", $update)),
    array_filter(explode("\n", $updates)),
);

$part1 = 0;
$part2 = 0;

foreach ($updates as $update) {
    if (all_rules_hold($rules, $update)) {
        $part1 += $update[(count($update) - 1) / 2];
    } else {
        rule_sort($rules, $update);
        $part2 += $update[(count($update) - 1) / 2];
    }
}

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;
