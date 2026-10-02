<?php

define('WORKERS', $argv[1] ?? 5);
define('STEP_DURATION', $argv[2] ?? 60);
$input = explode("\n", trim(stream_get_contents(STDIN)));
$steps = [];
$links = [];
foreach ($input as $line) {
    preg_match('/ (.) .+ (.) /', $line, $matches);
    [, $step, $before] = $matches;
    $steps[$step] ??= 1;
    $steps[$before] = 0;
    $links[$step][] = $before;
    $depends[$before][$step] = false;
}

ksort($steps);
ksort($depends);
ksort($links);
foreach ($links as &$list) {
    sort($list);
}

$visited = [];
$workers = array_fill(0, WORKERS, null);
$orderedSteps = '';
$duration = 0;

while (true) {
    foreach ($workers as &$worker) {
        if ($worker === null) {
            $step = null;

            foreach ($steps as $next => $state) {
                if (isset($visited[$next]) || !$state) {
                    continue;
                }
                $visited[$next] = true;
                $step = $next;
                break;
            }

            if ($step !== null) {
                $worker = [$step, STEP_DURATION + ord($step) - ord('A') + 1];
            } 
        }
    }
    unset($worker);

    while (array_all($workers, fn ($v) => is_array($v)) || array_sum($steps) == count($visited)) {
        $duration++;
        foreach ($workers as $i => $data) {
            if ($data === null) continue;
            [$step, $durationLeft] = $data;
            $durationLeft--;

            if ($durationLeft == 0) {
                $workers[$i] = null;

                foreach ($links[$step] ?? [] as $next) {
                    $depends[$next][$step] = true;
                    if (array_all($depends[$next], fn($v) => $v)) {
                        $steps[$next] = 1;
                    }
                }

                $orderedSteps .= $step;
                if (strlen($orderedSteps) == count($steps)) {
                    echo "$duration\n";
                    exit;
                }
            }
            else {
                $workers[$i][1] = $durationLeft;
            }
        }
    }
}
