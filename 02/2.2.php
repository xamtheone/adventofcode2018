<?php

$input = trim(stream_get_contents(STDIN));

$ids = [];
foreach (explode("\n", $input) as $id) {
    foreach($ids as $prev) {
        $common = common($id, $prev);
        if (strlen($common) == strlen($id) - 1) {
            echo "$common\n";
            exit;
        }
    }

    $ids[] = $id;
}

function common(string $a, string $b): string
{
    $common = '';
    for ($i = 0; $i < strlen($a); $i++) {
        if ($a[$i] == $b[$i]) {
            $common .= $a[$i];
        }
    }

    return $common;
}