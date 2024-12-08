<?php

$grid = file("input", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$grid = array_map('str_split', $grid);
$height = count($grid);
$width = count($grid[0]);

$frequencies = [];
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if ($grid[$y][$x] !== '.') {
            $frequencies[$grid[$y][$x]][] = [$y, $x];
        }
    }
}

$part1 = [];
$part2 = [];

foreach ($frequencies as $frequency) {
    for ($i = 0; $i < count($frequency) - 1; $i++) {
        for ($j = $i + 1; $j < count($frequency); $j++) {
            [[$y1, $x1], [$y2, $x2]] = [$frequency[$i], $frequency[$j]];
            [$dY, $dX] = [$y2 - $y1, $x2 - $x1];

            foreach ([[$y1 - $dY, $x1 - $dX], [$y2 + $dY, $x2 + $dX]] as [$y, $x]) {
                if ($y < 0 || $y >= $height || $x < 0 || $x >= $width) {
                    continue;
                }

                $part1["$y,$x"] = true;
            }

            foreach ([[$y1, $x1, 1], [$y2, $x2, -1]] as [$x, $y, $s]) {
                for ($k = 1;; $k++) {
                    $y2 = $x + $k * $dY * $s;
                    $x2 = $y + $k * $dX * $s;

                    if ($y2 < 0 || $y2 >= $height || $x2 < 0 || $x2 >= $width) {
                        break;
                    }

                    $part2["$y2,$x2"] = true;
                }
            }
        }
    }
}

echo count($part1) . PHP_EOL;
echo count($part2) . PHP_EOL;
