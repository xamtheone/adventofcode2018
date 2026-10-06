<?php

$input = (int) trim(fgets(STDIN));

$grid = [];
$max = -INF;
$bestX = 0;
$bestY = 0;
$bestS = 0;

$gridSize = 300;

for ($y = 1; $y <= $gridSize; $y++) {
    for ($x = 1; $x <= $gridSize; $x++) {
        $grid[$y][$x] = powerLevel($x, $y, $input);
    }
}

for ($y = 1; $y <= $gridSize; $y++) {
    for ($x = 1; $x <= $gridSize; $x++) {
        $zone = 0;
        for (
            $zoneSize = 1;
            $zoneSize <= $gridSize - max($x, $y) + 1;
            $zoneSize++
        ) {
            $ops = 0;
            for ($a = 0; $a < $zoneSize; $a++) {
                $zone += $grid[$y + $a][$x + $zoneSize - 1];
                $ops++;
                if ($a < $zoneSize - 1) {
                    $ops++;
                    $zone += $grid[$y + $zoneSize - 1][$x + $a];
                }
            }

            if ($zone > $max) {
                $max = $zone;
                $bestX = $x;
                $bestY = $y;
                $bestS = $zoneSize;
            }
        }
    }
}

echo "$bestX,$bestY,$bestS\n";

function powerLevel(int $x, int $y, int $sn): int
{
    $rackId = $x + 10;
    $powerLevel = $rackId * $y;
    $powerLevel += $sn;
    $powerLevel *= $rackId;
    $powerLevel = intdiv($powerLevel, 100) % 10;
    $powerLevel -= 5;

    return $powerLevel;
}
