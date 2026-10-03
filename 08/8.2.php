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
    $children = [];
    if ($nbChildren > 0) {
        for ($i = 0; $i < $nbChildren; $i++) {
            $pos++;
            $children[$i + 1] = dfsSumChildren($list, $pos);
        }
        for ($i = 1; $i <= $metadataLength; $i++) {
            $childIndex = $list[++$pos];
            $sum += $children[$childIndex] ?? 0;
        }
    } else {
        for ($i = 0; $i < $metadataLength; $i++) {
            $sum += $list[++$pos];
        }
    }

    return $sum;
}
