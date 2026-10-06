<?php

$input = (int) trim(fgets(STDIN));

$grid = [];
$max = 0;
$bestX = 0;
$bestY = 0;

$gridSize = 300;

for ($y = 1; $y <= $gridSize; $y++) {
    for ($x = 1; $x <= $gridSize; $x++) {
        $grid[$y][$x] = powerLevel($x, $y, $input);
    }
}

for ($y = 1; $y < $gridSize - 1; $y++) {
    for ($x = 1; $x < $gridSize - 1; $x++) {
        $zone = 0;
        foreach ([
            [0, 0],
            [1, 0],
            [2, 0],
            [0, 1],
            [1, 1],
            [2, 1],
            [0, 2],
            [1, 2],
            [2, 2],
        ] as [$dy, $dx]) {
            $zone += $grid[$y + $dy][$x + $dx];
        }

        if ($zone > $max) {
            $max = $zone;
            $bestX = $x;
            $bestY = $y;
        }
    }
}

echo "$bestX,$bestY\n";

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