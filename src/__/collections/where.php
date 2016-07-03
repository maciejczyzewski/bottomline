<?php

namespace collections;

/**
 * return data matching specific key value condition
 *
 **_::where($a, ['age' => 16]);
 ** // >> [['name' => 'maciej', 'age' => 16]]
 * @todo: implement compatibility with more than 2 dimensial arrays:
 **__::where($a, ['name' => 'fred & maciej', 'ages' => ['first' => 32]);
 ** // >> ['name' => 'fred & maciej', 'ages' => ['fred' => 32, 'maciej' => 16]]
 *
 * @param array $array array of values
 * @param array $cond  condition in format of ['KEY'=>'VALUE']
 * @return array
 */
function where(array $array = [], array $cond = [])
{
    $result = [];

    foreach ($array as $arrItem) {
        foreach ($cond as $condK => $condV) {
            if (isset($arrItem[$condK]) && $arrItem[$condK] !== $condV) {
                continue 2;
            }
        }

        $result[] = $arrItem;
    }

    return $result;
}
