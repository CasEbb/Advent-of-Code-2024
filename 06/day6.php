<?php

const DIRECTIONS = [
    [-1,  0],  // up
    [0,  1],  // right
    [1,  0],  // down
    [0, -1],  // left
];

$map = file_get_contents('input');
$map = array_filter(explode("\n", $map));
$map = array_map('str_split', $map);

$startPos = find_guard('^', $map);

$visited = walk($map, $startPos);
$part1 = sizeof($visited);

$part2 = 0;
foreach (array_keys($visited) as $pos) {
    $y = $pos >> 8;
    $x = $pos & 0xFF;
    $map[$y][$x] = '#';

    if (walk($map, $startPos) === 'INF') {
        $part2++;
    }

    $map[$y][$x] = '.';
}

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;

function walk($map, $pos)
{
    $height = sizeof($map);
    $width = sizeof($map[0]);

    $dir = 0;
    $visited[$pos] = $dir;

    while (true) {
        $y = $pos >> 8;
        $x = $pos & 0xFF;

        $y += DIRECTIONS[$dir][0];
        $x += DIRECTIONS[$dir][1];

        // Out of bounds?
        if ($y < 0 || $y >= $height || $x < 0 || $x >= $width) {
            break;
        }

        // Collision?
        if ($map[$y][$x] == '#') {
            // Turn
            $dir = (++$dir) % 4;

            continue;
        }

        // Move
        $pos = ($y << 8) | $x;

        if (! isset($visited[$pos])) {
            $visited[$pos] = 1 << $dir;
        } elseif ($visited[$pos] & (1 << $dir)) {
            return 'INF';
        } else {
            $visited[$pos] |= 1 << $dir;
        }
    }

    return $visited;
}

function find_guard($needle, array $haystack)
{
    foreach ($haystack as $y => $row) {
        if ($x = array_search($needle, $row)) {
            return ($y << 8) | $x;
        }
    }
}
