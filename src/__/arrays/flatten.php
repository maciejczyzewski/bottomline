<?php

namespace arrays;

/**
 * @internal
 *
 * @param iterable|\Traversable $iterable
 * @param bool                  $shallow
 *
 * @return \Generator
 */
function flattenIterable($iterable, $shallow = false)
{
    foreach ($iterable as $value) {
        if (\__::isIterable($value, true)) {
            if (!$shallow) {
                $value = flatten($value, $shallow);
            }

            foreach ($value as $valItem) {
                yield $valItem;
            }
        } else {
            yield $value;
        }
    }
}

/**
 * Flattens a multidimensional array or iterable.
 *
 * If `$shallow` is set to TRUE, the array will only be flattened a single level.
 *
 * **Usage**
 *
 * ```php
 * __::flatten([1, 2, [3, [4]]], false);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 2, 3, 4]
 * ```
 *
 * @since 0.2.0 iterable objects are now supported
 *
 * @param iterable $iterable
 * @param bool     $shallow
 *
 * @return array|\Generator
 */
function flatten($iterable, $shallow = false)
{
    $generator = flattenIterable($iterable, $shallow);

    if (is_array($iterable)) {
        return iterator_to_array($generator);
    }

    return $generator;
}
