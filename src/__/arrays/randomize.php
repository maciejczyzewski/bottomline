<?php

namespace arrays;

/**
 * Shuffle an array
 *
 ** __::randomize([1, 2, 3]);
 ** // → [2, 3, 1]
 *
 * @param array $array original array
 *
 * @return array
 *
 */
function randomize(array $array = [])
{
    shuffle($array);

    return $array;
}