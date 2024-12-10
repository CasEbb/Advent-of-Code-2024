<?php

const DIRECTIONS = [
    [-1,  0],  // up
    [ 0,  1],  // right
    [ 1,  0],  // down
    [ 0, -1],  // left
];

$map = file("input", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$map = array_map('str_split', $map);
$height = count($map);
$width = count($map[0]);
$part1 = 0;
$part2 = 0;

function trail($y, $x, $isPart2 = false)
{
    global $map, $height, $width;

    $queue = [[$y, $x]];
    $visited = [];
    $result = 0;

    while ($queue) {
        [$y, $x] = array_pop($queue);

        if (! $isPart2) {
            $key = ($y << 8) + $x;

            if (array_key_exists($key, $visited)) {
                continue;
            }

            $visited[$key] = true;
        }

        if ($map[$y][$x] == 0) {
            $result++;
            continue;
        }

        foreach (DIRECTIONS as [$dY, $dX]) {
            $newY = $y + $dY;
            $newX = $x + $dX;

            if ($newY < 0 || $newY >= $height || $newX < 0 || $newX >= $width) {
                continue;
            }

            if ($map[$newY][$newX] == $map[$y][$x] - 1) {
                array_push($queue, [$newY, $newX]);
            }
        }
    }

    return $result;
}

function part1($y, $x)
{
    return trail($y, $x, false);
}

function part2($y, $x)
{
    return trail($y, $x, true);
}

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if ($map[$y][$x] != 9) {
            continue;
        }

        $part1 += part1($y, $x);
        $part2 += part2($y, $x);
    }
}

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;
