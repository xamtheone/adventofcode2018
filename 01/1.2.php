<?php
$input = trim(stream_get_contents(STDIN));
$freqs = [];
$freq = 0;
$list = explode("\n", str_replace('+', '', $input));
while (true) {
    foreach ($list as $val) {
        $freq += $val;
        if (isset($freqs[$freq])) {
            echo "$freq\n";
            exit;
        }
        $freqs[$freq] = true;
    }
}
