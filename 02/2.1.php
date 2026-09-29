<?php
$input = trim(stream_get_contents(STDIN));
$c2 = 0;
$c3 = 0;
foreach (explode("\n", $input) as $id) {
    $counts = [];
    for ($i = 0; $i < strlen($id); $i++) {
        @$counts[$id[$i]]++;
    }
    if (in_array(2, $counts)) {
        $c2++;
    }
    if (in_array(3, $counts)) {
        $c3++;
    }
}
echo $c2 * $c3, "\n";
