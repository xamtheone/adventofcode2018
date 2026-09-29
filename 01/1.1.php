<?php
$input = trim(stream_get_contents(STDIN));
echo array_sum(explode("\n", str_replace('+', '', $input))) . "\n";