<?php

$input = explode("\n", trim(stream_get_contents(STDIN)));
$steps = [];
$links = [];
foreach ($input as $line) {
    preg_match('/ (.) .+ (.) /', $line, $matches);
    [, $step, $before] = $matches;
    $steps[$step] ??= true;
    $steps[$before] = false;
    $links[$step][] = $before;
    $depends[$before][$step] = false;
}

ksort($steps);
ksort($depends);
ksort($links);
foreach ($links as &$list) {
    sort($list);
}

$keys = array_filter($steps, fn ($v) => $v);
$Q = [array_key_first($keys)];
$visited = [array_key_first($keys) => true];
while ($Q) {
    $step = array_shift($Q);

    echo $step;

    foreach ($links[$step] ?? [] as $next) {
        $depends[$next][$step] = true;
        if (array_all($depends[$next], fn ($v) => $v)) {
            $steps[$next] = true;
        }
    }

    foreach ($steps as $next => $state) {
        if (isset($visited[$next]) || !$state) continue;
        $visited[$next] = true;
        $Q[] = $next;
        break;
    }
}
echo "\n";