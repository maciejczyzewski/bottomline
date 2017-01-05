<?php

namespace arrays;

/**
 * Creates  an  array  with  all  falsey  values removed. The values
 * false, null, 0, "", undefined, and NaN are all falsey.
 *
 ** __::compact([0, 1, false, 2, '', 3]);
 ** // → [1, 2, 3]
 *
 * @param array $array array to compact
 *
 * @return array
 *
 */
function compact(array $array)
{
    return \array_values(\array_filter($array));
}

