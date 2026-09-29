<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));
sort($input);

$guards = [];
$sleepSpans = [];
$id = '';
foreach ($input as $line) {
    $time = (int) str_replace(':', '', substr($line, 12, 5));
    $state = substr($line, 19);
    if (preg_match('/\d+/', $state, $matches)) {
        $id = $matches[0];
        $guards[$id] ??= 0;
    }
    if ($state == "falls asleep") {
        $timeAsleep = $time;
    } elseif ($state == "wakes up") {
        $guards[$id] += $time - $timeAsleep;
        $sleepSpans[$id][] = [$timeAsleep, $time];
    }
}

arsort($guards);
$topId = array_key_first($guards);

$minuteSpan = [];
foreach ($sleepSpans[$topId] as [$start, $end]) {
    for ($i = $start; $i < $end; $i++) {
        $minuteSpan[$i] ??= 0;
        $minuteSpan[$i]++;
    }
}

arsort($minuteSpan);
$minute = array_key_first($minuteSpan);

echo $topId * $minute, "\n";
