<?php

$input = trim(fgets(STDIN));

preg_match('/^(\d+).* worth (\d+)[^\d]+( is (\d+))?$/', $input, $matches);
[, $nbPlayers, $lastMarbleValue] = $matches;
$testHighScore = $matches[4] ?? null;

$players = array_fill(0, $nbPlayers, 0);

$marbles = [0];

$currentMarbleIndex = 0;
$marble = 0;

for ($turn = 0; $turn < $lastMarbleValue; $turn++) {
    $player = $turn % $nbPlayers;
    $marble++;

    if ($marble % 23 == 0) {
        $players[$player] += $marble;

        $removeIndex =
            (($currentMarbleIndex - 7) % count($marbles) + count($marbles)) %
            count($marbles);
        $players[$player] += $marbles[$removeIndex];
        $marbles = array_merge(
            array_slice($marbles, 0, $removeIndex),
            array_slice($marbles, $removeIndex + 1),
        );
        $currentMarbleIndex = $removeIndex % count($marbles);
    } else {
        $leftLength = (($currentMarbleIndex + 1) % count($marbles)) + 1;
        $rightStart = $leftLength;
        $left = array_slice($marbles, 0, $leftLength);
        $marbles = array_merge(
            $left,
            [$marble],
            array_slice($marbles, $rightStart),
        );
        $currentMarbleIndex = count($left);
    }
}

if ($testHighScore !== null) {
    echo "expected: $testHighScore, found: ";
}
echo max($players) . "\n";
