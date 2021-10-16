<?php

namespace collections;

/**
 * @param array|iterable                  $array
 * @param bool|\Closure|double|int|string $condition
 *
 * @see find
 * @see findIndex
 * @see findLast
 * @see where
 *
 * @since 0.2.1
 *
 * @return mixed|null
 */
function findLastIndex($array, $condition)
{
    return \__::findIndex(\__::reverseIterable($array), $condition);
}
