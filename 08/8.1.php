<?php

$input = explode(' ', trim(fgets(STDIN)));
$pos = 0;
echo dfsSumChildren($input, $pos);
echo "\n";

function dfsSumChildren(array $list, int &$pos): int
{
    $nbChildren = $list[$pos];
    $pos++;
    $metadataLength = $list[$pos];
    $sum = 0;
    for ($i = 0; $i < $nbChildren; $i++) {
        $pos++;
        $sum += dfsSumChildren($list, $pos);
    }
    for ($i = 0; $i < $metadataLength; $i++) {
        $sum += $list[++$pos];
    }

    return $sum;
}
