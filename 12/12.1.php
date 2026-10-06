<?php

$debug = in_array("-d", $argv);
$input = trim(stream_get_contents(STDIN));

[$initialState, $instructions] = explode("\n\n", $input);
$initialState = explode(" ", $initialState)[2];
$instructions = explode("\n", $instructions);

$pots = [];
$mapInstructions = [];
foreach ($instructions as $ins) {
    [$a, $b] = explode(" => ", $ins);
    $mapInstructions[$a] = $b;
}

$state = array_fill(-20, strlen($initialState) + 40, ".");
for ($i = 0; $i < strlen($initialState); $i++) {
    $state[$i] = $initialState[$i];
}

if ($debug) {
    echo implode("", $state) . "\n";
}

for ($i = 0; $i < 20; $i++) {
    $prev = $state;
    $state = array_fill(-20, strlen($initialState) + 40, ".");

    for ($j = -18; $j < strlen($initialState) + 18; $j++) {
        $key =
            $prev[$j - 2] .
            $prev[$j - 1] .
            $prev[$j] .
            $prev[$j + 1] .
            $prev[$j + 2];

        $state[$j] = $mapInstructions[$key] ?? ".";
    }

    if ($debug) {
        echo implode("", $state) . "\n";
    }
}

$sum = 0;
foreach ($state as $i => $v) {
    if ($v == "#") {
        $sum += $i;
    }
}

echo "$sum\n";
