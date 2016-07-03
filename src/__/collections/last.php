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
    return !$take ? \array_pop($array) : \array_slice($array, -$take);
}
