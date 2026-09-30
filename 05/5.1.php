<?php

$input = trim(fgets(STDIN));

$unitGroups = [];
foreach (range('a', 'z') as $c) {
    $unitGroups[] = $c . strtoupper($c);
    $unitGroups[] = strtoupper($c) . $c;
}

$replacements = array_fill(0, count($unitGroups), '');

$curr = $input;
$prev = '';
while ($curr != $prev) {
    $prev = $curr;
    $curr = str_replace($unitGroups, $replacements, $curr);
}

echo strlen($curr) . "\n";
