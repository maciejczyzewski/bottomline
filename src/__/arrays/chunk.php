<?php

namespace arrays;

/**
 * @internal
 *
 * @param \Traversable $iterable
 * @param int          $size
 * @param bool         $preserveKeys
 *
 * @return \Generator
 */
function chunkIterable($iterable, $size, $preserveKeys)
{
    $iterator = \__::getIterator($iterable);

    $workspace = [];
    $counter = 0;

    foreach ($iterator as $key => $item) {
        if ($counter === $size) {
            yield $workspace;

            // Reset our workspace after we've yielded our last chunk
            $workspace = [];
            $counter = 0;
        }

        $key = $preserveKeys ? $key : $counter;
        $workspace[$key] = $item;
        ++$counter;
    }

    yield $workspace;
}

/**
 * Creates an array of elements split into groups the length of `$size`.
 *
 * If array can't be split evenly, the final chunk will be the remaining
 * elements. When `$preserveKeys` is set to TRUE, keys will be preserved.
 * Default is FALSE, which will reindex the chunk numerically.
 *
 * **Usage**
 *
 * ```php
 * __::chunk([1, 2, 3, 4, 5], 3);
 * ```
 *
 * **Result**
 *
 * ```
 * [[1, 2, 3], [4, 5]]
 * ```
 *
 * @since 0.2.0 iterable objects are now supported
 *
 * @param iterable $iterable     The original array
 * @param int      $size         The chunk size
 * @param bool     $preserveKeys Whether or not to preserve index keys
 *
 * @throws \InvalidArgumentException when an non-array or non-traversable object is given for $iterable.
 * @throws \Exception                when an `\IteratorAggregate` is given and `getIterator()` throws an exception.
 *
 * @return array|\Generator When given a `\Traversable` object for `$iterable`, a generator will be returned.
 *                          Otherwise, an array will be returned.
 */
function chunk($iterable, $size = 1, $preserveKeys = false)
{
    if (is_array($iterable)) {
        return \array_chunk($iterable, $size, $preserveKeys);
    }

    return chunkIterable($iterable, $size, $preserveKeys);
}
