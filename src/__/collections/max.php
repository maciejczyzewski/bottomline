<?php

namespace collections;

/**
 * Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.
 *
 * @param array $array array
 *
 * @return mixed maximum value
 *
 */
function max(array $array = [])
{
    return \max($array);
}
