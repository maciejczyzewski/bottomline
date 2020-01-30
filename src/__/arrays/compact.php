<?php

namespace arrays;

/**
 * @internal
 *
 * @param \Traversable $iterable
 *
 * @return \Generator
 */
function compactIterable($iterable)
{
    foreach (\__::getIterator($iterable) as $item) {
        if ($item) {
            yield $item;
        }
    }
}

/**
 * Creates an array with all falsey values removed.
 *
 * The following values are considered falsey:
 *
 * - `false`
 * - `null`
 * - `0`
 * - `""`
 * - `undefined`
 * - `NaN`
 *
 * **Usage**
 *
 * ```php
 * __::compact([0, 1, false, 2, '', 3]);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 2, 3]
 * ```
 *
 * @since 0.2.0 iterable objects are now supported
 *
 * @param iterable $iterable The array to compact
 *
 * @return array|\Generator
 */
function compact($iterable)
{
    if (is_array($iterable)) {
        return \array_values(\array_filter($iterable));
    }

    return compactIterable($iterable);
}
