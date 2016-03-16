<?php

namespace arrays;

/**
 * generate range of values based on start , end and step
 ** __::range(1, 10, 2);
 ** // → [1, 3, 5, 7, 9]
 *
 * @param integer|null $start range start
 * @param integer|null $stop  range end
 * @param integer      $step  range step value
 *
 * @return array range of values
 *
 */
function range($start = null, $stop = null, $step = 1)
{
    if ($stop == null && $start != null) {
        $stop  = $start;
        $start = 1;
    }

    return \range($start, $stop, $step);
}
