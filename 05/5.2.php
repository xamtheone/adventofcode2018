<?php

$input = trim(fgets(STDIN));

$unitGroups = [];
foreach (range('a', 'z') as $c) {
    $unitGroups[] = $c . strtoupper($c);
    $unitGroups[] = strtoupper($c) . $c;
}

$replacements = array_fill(0, count($unitGroups), '');

$best = PHP_INT_MAX;
foreach (range('a', 'z') as $c) {
    $curr = str_ireplace($c, '', $input);
    $prev = '';
    while ($curr != $prev) {
        $prev = $curr;
        $curr = str_replace($unitGroups, $replacements, $curr);
    }
    $best = min($best, strlen($curr));
}

echo $best . "\n";
