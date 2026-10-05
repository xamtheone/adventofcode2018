<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));

$points = [];
$grid = [];

foreach ($input as $line) {
    preg_match('/position=< ?(-?\d+),  ?(-?\d+)> velocity=< ?(-?\d+),  ?(-?\d+)>/', $line, $matches);
    $point = [
        'px' => (int) $matches[1],
        'py' => (int) $matches[2],
        'vx' => (int) $matches[3],
        'vy' => (int) $matches[4],
    ];

    $points[] = $point;

    $grid[$point['px']][$point['py']] = true;
}

$offset = -5;
$size = 20;

$top = INF;
$right = -INF;
$bottom = -INF;
$left = INF;

for ($s = 0; $s <= 20000; $s++) {
    $display = $s && $bottom - $top <= 10;

    if ($display) {
        for ($y = $top; $y <= $bottom; $y++) {
            for ($x = $left; $x <= $right; $x++) {
                echo ($grid[$x][$y] ?? false) ? '#' : '.';
            }
            echo "\n";
        }
        echo "\n";
        echo "$s\n";
        break;
    }

    $grid = [];
    $top = INF;
    $right = -INF;
    $bottom = -INF;
    $left = INF;

    foreach ($points as &$point) {
        $point['px'] += $point['vx'];
        $point['py'] += $point['vy'];
        $top = min($point['py'], $top);
        $bottom = max($point['py'], $bottom);
        $left = min($point['px'], $left);
        $right = max($point['px'], $right);

        $grid[$point['px']][$point['py']] = true;
    }
    unset($point);
}
