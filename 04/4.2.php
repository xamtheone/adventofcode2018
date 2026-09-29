<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));
sort($input);

$sleepSpans = [];
$id = '';
foreach ($input as $line) {
    $time = (int) str_replace(':', '', substr($line, 12, 5));
    $state = substr($line, 19);
    if (preg_match('/\d+/', $state, $matches)) {
        $id = $matches[0];
    }
    if ($state == "falls asleep") {
        $timeAsleep = $time;
    } elseif ($state == "wakes up") {
        $sleepSpans[$id][] = [$timeAsleep, $time];
    }
}

$max = 0;
$maxId = 0;
$maxMinute = 0;
foreach ($sleepSpans as $id => $spans) {
    $minuteSpan = [];
    foreach ($spans as [$start, $end]) {
        for ($i = $start; $i < $end; $i++) {
            $minuteSpan[$i] ??= 0;
            $minuteSpan[$i]++;
        }
    }

    arsort($minuteSpan);
    $minute = array_key_first($minuteSpan);
    $count = $minuteSpan[$minute];
    if ($count > $max) {
        $max = $count;
        $maxMinute = $minute;
        $maxId = $id;
    }
}

echo $maxId * $maxMinute, "\n";
