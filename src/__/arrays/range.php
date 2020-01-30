<?php

namespace arrays;

/**
 * Generate range of values based on start, end, and step.
 *
 * **Usage**
 *
 * ```php
 * __::range(1, 10, 2);
 * ```
 *
 * **Result**
 *
 * ```
 * [1, 3, 5, 7, 9]
 * ```
 *
 * @param int $start range start
 * @param int $stop  range end
 * @param int $step  range step value
 *
 * @return array range of values
 */
function range($start, $stop = null, $step = 1)
{
    if ($stop === null) {
        $stop = $start;
        $start = 1;
    }

    return \range($start, $stop, $step);
}
