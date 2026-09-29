<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));

$fabric = [];
foreach ($input as $line) {
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $line, $matches);
    [, $id, $left, $top, $width, $height] = $matches;
    
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

echo array_sum($fabric) . "\n";
