<?php

namespace collections;

/**
 * return data matching specific key value condition
 *
 **_::where($a, ['age' => 16]);
 ** // >> [['name' => 'maciej', 'age' => 16]]
 *
 * @param array $array array of values
 * @param array $key   condition in format of ['KEY'=>'VALUE']
 *
 * @return array
 *
 */
function where(array $array = array(), array $key = array())
{
    $result = array();

    foreach ($array as $k => $v) {
        $not = false;

        foreach ($key as $j => $w) {
            if (\objects\isArray($w)) {
                if (count(array_intersect($w, $v[$j])) == 0) {
                    $not = true;
                    break;
                }
            } else {
                if (!isset($v[$j]) || $v[$j] != $w) {
                    $not = true;
                    break;
                }
            }
        }

        if ($not == false) {
            $result[] = $v;
        }
    }

    return $result;
}
