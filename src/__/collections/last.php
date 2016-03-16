<?php

namespace collections;

/**
 * get last item(s) of an array
 *
 * @param array $array array of values
 * @param null  $take  number of returned values
 *
 * @return array|mixed
 *
 */
function last($array, $take = null)
{
    if (!$take) {
        return \array_pop($array);
    }

    return \array_splice($array, -$take);
}
