<?php

namespace arrays;

/**
 * @arrays @range
 *
 ** __::range(1, 10, 2);
 ** // → [1, 3, 5, 7, 9]
 */

function range($start = null, $stop = null, $step = 1)
{
    if($stop == null && $start != null)
    {
        $stop = $start;
        $start = 1;
    }

    return \range($start, $stop, $step);
}