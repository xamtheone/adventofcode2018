<?php

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

$counts = array_fill(0, count($coords), 0);

for ($y = 0; $y < $H; $y++) {
    for ($x = 0; $x < $W; $x++) {
        $closestCoords = closestCoords($coords, $x, $y);
        if (count($closestCoords) == 1) {
            $counts[$closestCoords[0]]++;
        }
    }
}

foreach ($coords as $i => [$x, $y]) {
    foreach ([
        [$x, 0],
        [$x, $maxY],
        [0, $y],
        [$maxX, $y],
    ] as [$xx, $yy]) {
        $closestCoords = closestCoords($coords, $xx, $yy);
        if (count($closestCoords) == 1 && $closestCoords[0] == $i) {
            $counts[$i] = 0;
        }
    }
}

echo max($counts) . "\n";

function closestCoords(array $coords, int $x, int $y): array
{
    $bestDist = INF;
    $map = [];

    foreach ($coords as $i => [$cX, $cY]) {
        $manhattanDist = abs($x - $cX) + abs($y - $cY);

        $map[$manhattanDist][] = $i;

        if ($manhattanDist <= $bestDist) {
            $bestDist = $manhattanDist;
        }
    }

    return $map[$bestDist];
}
