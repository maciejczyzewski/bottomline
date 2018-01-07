<?php

namespace collections;

/**
 * Set item of a collection by index to given value, accepting nested index.
 *
 ** __::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
 ** // → '['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]'
 *
 * @param array|object $collection collection of values
 * @param string  $path        key or index
 * @param mixed   $value      the value to set at position $key
 * @param boolean $strict     if the path should be generated even if the path consists of non collections
 * @throws \Exception if the path consists of a non collection and strict is set to false
 *
 * @return array|object the manipulated collection
 *
 */
function set($collection, $keys, $value = null, $strict = false)
{
    $set_object = function (&$object, $key, $value) {
        $object->$key = $value;
        return $object;
    };
    $set_array = function (&$array, $key, $value) {
        $array[$key] = $value;
        return $array;
    };
    $setter = \__::isObject($collection) ? $set_object : $set_array;

    if ($keys === null) {
        return $collection;
    }

    $keys = \explode('.', $keys);
    $key  = \array_shift($keys);

    if (\count($keys) === 0) {
        call_user_func_array($setter, [&$collection, $key, $value]);
        // $collection = call_user_func_array($setter, [&$collection, $key, $value]);
    } else {
        if (!\__::has($collection, $key) || (!\is_array(\__::get($collection, $key)) && $strict)) {
            $collection[$key] = [];
        } elseif (!\is_array(\__::get($collection, $key))) {
            throw new \Exception(sprintf('Could not insert value %s into array because the value at key %s is no array.', $value, $key));
        }
        call_user_func_array(
            $setter,
            [&$collection, $key, set(\__::get($collection, $key), implode('.', $keys), $value)]
        );
    }

    return $collection;
}
