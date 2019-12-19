<?php

namespace arrays;

/**
 * Creates a slice of array with n elements dropped from the beginning.
 *
 * **Usage**
 *
 * ```php
 * __::drop([0, 1, 3, 5], 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [3, 5]
 * ```
 *
 * @param array|iterable $input  The array or iterable to query.
 * @param int            $number The number of elements to drop.
 *
 * @throws \Exception
 *
 * @return array|iterable
 */
function drop(/*iterable*/ $input, $number = 1)
{
    if (is_array($input)) {
        return array_slice($input, $number);
    }

    if ($input instanceof \Iterator) {
        for ($i = 0; $i < $number; $i++) {
            $input->next();
        }

        return $input;
    }

    if ($input instanceof \IteratorAggregate) {
        $itr = $input->getIterator();

        return drop($itr, $number);
    }

    throw new \InvalidArgumentException('$input should implement the Iterator or IteratorAggregate interface');
}
