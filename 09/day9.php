<?php

$diskMap = trim(file_get_contents("input"));

$disk = fresh_disk($diskMap);
$part1 = part1($disk);

$disk = fresh_disk($diskMap);
$part2 = part2($disk);

echo $part1 . PHP_EOL;
echo $part2 . PHP_EOL;

function fresh_disk(string $diskMap): array
{
    $disk = [];
    foreach (str_split($diskMap) as $index => $char) {
        $value = $index % 2 ? '.' : intdiv($index, 2);
        $disk = array_merge($disk, array_fill(0, $char, $value));
    }
    return $disk;
}

function part1(array $disk): int
{
    for ($i = count($disk) - 1; $i >= 0; $i--) {
        $index = array_search('.', $disk, true);
        if ($index === false) break;

        if ($disk[$i] !== '.') {
            $disk[$index] = $disk[$i];
        }
        array_pop($disk);
    }

    return array_sum(
        array_map(
            fn($value, $index) => $value * $index,
            $disk,
            array_keys($disk)
        )
    );
}

function part2(array $disk): int
{
    for ($i = count($disk) - 1; $i >= 0; $i--) {
        if ($disk[$i] === '.') continue;

        $block = $disk[$i];
        $current = $i;

        while (isset($disk[$current]) && $disk[$current] === $block) {
            $current--;
        }

        $blocks = array_slice($disk, $current + 1, $i - $current);

        for ($j = 0; $j < $i; $j++) {
            if ($disk[$j] !== '.') continue;

            $current = $j;
            while (isset($disk[$current]) && $disk[$current] === '.') {
                $current++;
            }

            $emptySpaces = array_slice($disk, $j, $current - $j);

            if (count($emptySpaces) >= count($blocks)) {
                array_splice($disk, $j, count($blocks), $blocks);
                array_splice(
                    $disk,
                    $i - count($blocks) + 1,
                    count($blocks),
                    array_fill(0, count($blocks), '.')
                );
                break;
            }

            $j += count($emptySpaces);
        }

        $i -= count($blocks) - 1;
    }

    return array_sum(
        array_map(
            fn($value, $index) => $value !== '.' ? $value * $index : 0,
            $disk,
            array_keys($disk)
        )
    );
}
