<?php

namespace collections;

/**
 * Returns the values in the collection that pass the truth test.
 *
 * @param array    $array   array to filter
 * @param \Closure $closure closure to filter array based on
 *
 * @return array
 *
 */
function filter(array $array = array(), \Closure $closure)
{
    if (!$closure) {
        return \arrays\compact($array);
    } else {
        $result = array();

        foreach ($array as $key => $value) {
            if (\call_user_func($closure, $value)) {
                $result[] = $value;
            }
        }

        return $result;
    }
}
