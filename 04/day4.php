<?php

const WORD = 'XMAS';

const DIRECTIONS = [
    [0, 1],   // Right
    [1, 0],   // Down
    [0, -1],  // Left
    [-1, 0],  // Up
    [-1, -1], // Diagonal Up-Left
    [-1, 1],  // Diagonal Up-Right
    [1, -1],  // Diagonal Down-Left
    [1, 1],   // Diagonal Down-Right
];

function checkPart1($grid, $x, $y)
{
    if ($grid[$y][$x] !== 'X') {
        return;
    }

    $rows = count($grid);
    $cols = count($grid[0]);

    $found = 0;

    foreach (DIRECTIONS as [$dx, $dy]) {
        for ($i = 0; $i < strlen(WORD); $i++) {
            $nx = $x + ($i * $dx);
            $ny = $y + ($i * $dy);

            if ($nx < 0 || $nx >= $cols || $ny < 0 || $ny >= $rows || $grid[$ny][$nx] !== WORD[$i]) {
                continue 2;
            }
        }

        $found++;
    }

    return $found;
}

function checkPart2($grid, $x, $y)
{
    return isset($grid[$y + 1][$x + 1])
        && isset($grid[$y + 2][$x + 2])
        && isset($grid[$y][$x + 2])
        && isset($grid[$y + 2][$x])
        && $grid[$y + 1][$x + 1] === 'A'
        && (
            ($grid[$y][$x + 2] === 'M' && $grid[$y + 2][$x] === 'S')
            || ($grid[$y][$x + 2] === 'S' && $grid[$y + 2][$x] === 'M')
        )
        && (
            ($grid[$y][$x] === 'M' && $grid[$y + 2][$x + 2] === 'S')
            || ($grid[$y][$x] === 'S' && $grid[$y + 2][$x + 2] === 'M')
        );
}

$grid = file_get_contents('input');
$grid = array_filter(explode("\n", $grid));
$grid = array_map('str_split', $grid);

$part1 = 0;
$part2 = 0;

for ($x = 0; $x < count($grid[0]); $x++) {
    for ($y = 0; $y < count($grid); $y++) {
        $part1 += checkPart1($grid, $x, $y);
        $part2 += checkPart2($grid, $x, $y);
    }
}

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;
