<?php

namespace arrays;

function range($start = null, $stop = null, $step = 1)
{
    if($stop == null && $start != null)
    {
        $stop = $start;
        $start = 1;
    }

    return \range($start, $stop, $step);
}