<?php

namespace collections;

/**
 * @param array|iterable                  $array
 * @param bool|\Closure|double|int|string $condition
 *
 * @see find
 * @see findIndex
 * @see findLastIndex
 * @see where
 *
 * @since 0.2.1
 *
 * @return mixed|null
 */
function findLast($array, $condition)
{
    return \__::find(\__::reverseIterable($array), $condition);
}
