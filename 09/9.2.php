<?php

// Near ~660MB and 1min for real input

$input = trim(fgets(STDIN));

preg_match('/^(\d+).* worth (\d+)[^\d]+( is (\d+))?$/', $input, $matches);
[, $nbPlayers, $lastMarbleValue] = $matches;
$nbPlayers = (int) $nbPlayers;
$testHighScore = $matches[4] ?? null;

$lastMarbleValue *= 100;
$players = array_fill(0, $nbPlayers, 0);

$currentMarble = new Marble();
$currentMarble->prev = $currentMarble;
$currentMarble->next = $currentMarble;
$marbleValue = 0;

for ($turn = 0; $turn < $lastMarbleValue; $turn++) {
    $player = $turn % $nbPlayers;
    $marbleValue++;
    $marble = new Marble($marbleValue);

    if ($marbleValue % 23 == 0) {
        $players[$player] += $marbleValue;
        $removedMarble = $currentMarble;
        for ($i = 0; $i < 7; $i++) {
            $removedMarble = $removedMarble->prev;
        }

        $players[$player] += $removedMarble->value;

        $nextMarble = $removedMarble->next;
        $prevMarble = $removedMarble->prev;
        $prevMarble->next = $nextMarble;
        $nextMarble->prev = $prevMarble;
        unset($removedMarble);

        $currentMarble = $nextMarble;
    } else {
        $nextMarble = $currentMarble->next;
        $nextNextMarble = $nextMarble->next;
        $currentMarble = new Marble($marbleValue, $nextMarble, $nextNextMarble);
        $nextMarble->next = $currentMarble;
        $nextNextMarble->prev = $currentMarble;
    }
}

if ($testHighScore !== null) {
    echo "expected: $testHighScore, found: ";
}
echo max($players) . "\n";

class Marble
{
    public function __construct(
        public int $value = 0,
        public ?Marble $prev = null,
        public ?Marble $next = null,
    ) {}
}
