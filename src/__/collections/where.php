<?php

namespace collections;

/**
 * Return data matching specific key value condition.
 *
 * **Usage**
 *
 * ```php
 * $a = [
 *     ['name' => 'fred',   'age' => 32],
 *     ['name' => 'maciej', 'age' => 16]
 * ];
 *
 * __::where($a, ['age' => 16]);
 * ```
 *
 * **Result**
 *
 * ```
 * [['name' => 'maciej', 'age' => 16]]
 * ```
 *
 * @todo: implement compatibility with more than 2 dimensional arrays:
 *
 * @param array|iterable $array array of values
 * @param array          $cond  condition in format of ['KEY'=>'VALUE']
 *
 * @return array
 */
function where($array = [], array $cond = [])
{
    $result = [];
    foreach ($array as $arrItem) {
        foreach ($cond as $condK => $condV) {
            if (!isset($arrItem[$condK]) || $arrItem[$condK] !== $condV) {
                continue 2;
            }
        }
        $result[] = $arrItem;
    }

    return $result;
}
