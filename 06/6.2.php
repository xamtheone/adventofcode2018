<?php

const LIMIT = 10000;
$input = explode("\n", trim(stream_get_contents(STDIN)));
$maxX = 0;
$maxY = 0;
foreach ($input as $i => $line) {
    [$x, $y] = explode(', ', $line);
    $maxX = max($x, $maxX);
    $maxY = max($y, $maxY);
    $coords[$i] = [$x, $y];
}

$H = $maxY + 1;
$W = $maxX + 1;

$regionSize = 0;
for ($y = 0; $y < $H; $y++) {
    for ($x = 0; $x < $W; $x++) {
        $sum = sumDistance($coords, $x, $y);
        if ($sum < LIMIT) {
            $regionSize++;
        }
    }
}

echo $regionSize . "\n";

function sumDistance(array $coords, int $x, int $y): int
{
    $manhattanDist = 0;

    foreach ($coords as [$cX, $cY]) {
        $manhattanDist += abs($x - $cX) + abs($y - $cY);
    }

    return $manhattanDist;
}
