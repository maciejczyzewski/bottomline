<?php

namespace collections;

/**
 * @collections @last
 */

function last($array, $take = null)
{
    if(!$take) return \array_pop($array);

    return \array_splice($array, -$take);
}
