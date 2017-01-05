<?php

namespace arrays;

/**
 * Shuffle an array ensuring no item remains in the same position.
 *
 ** __::randomize([1, 2, 3]);
 ** // → [2, 3, 1]
 *
 * @param array $array original array
 *
 * @return array
 *
 */
function randomize(array $array)
{
    for ($i = 0, $c = \count($array); $i < $c - 1; $i++) {
        $j = \rand($i + 1, $c - 1);
        list($array[$i], $array[$j]) = [$array[$j], $array[$i]];
    }

    return $array;
}
