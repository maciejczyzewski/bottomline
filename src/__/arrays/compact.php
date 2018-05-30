<?php

namespace arrays;

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
 * @param array $array The array to compact
 *
 * @return array
 */
function compact(array $array)
{
    return \array_values(\array_filter($array));
}

