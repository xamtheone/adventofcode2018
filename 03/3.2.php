<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));

$fabric = [];
$claims = [];
foreach ($input as $line) {
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $line, $matches);
    [, $id, $left, $top, $width, $height] = $matches;
    $claims[$id] = [$left, $top, $width, $height];
    
    for ($x = $left; $x < $left + $width; $x++) {
        for ($y = $top; $y < $top + $height; $y++) {
            if (!isset($fabric["$x $y"])) {
                $fabric["$x $y"] = 0;
            } else {
                $fabric["$x $y"] = 1;
            }
        }
    }
}

foreach ($claims as $id => [$left, $top, $width, $height]) {
    $overlap = false;    
    for ($x = $left; $x < $left + $width; $x++) {
        for ($y = $top; $y < $top + $height; $y++) {
            if ($fabric["$x $y"] == 1) {
                $overlap = true;
                break 2;
            }
        }
    }

    if (!$overlap) {
        echo "$id\n";
        exit;
    }
}
