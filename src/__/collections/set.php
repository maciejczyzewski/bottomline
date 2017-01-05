<?php

namespace collections;

/**
 * Set item of an array by index to given value, accepting nested index
 *
 ** __::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
 ** // → '['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]'
 *
 * @param array   $collection array of values
 * @param string  $key        key or index
 * @param mixed   $value      the value to set at position $key
 * @param boolean $strict     if the path should be generated even if the path consists of non collections
 * @throws \Exception if the path consists of a non collection and strict is set to false
 *
 * @return array the manipulated array
 *
 */
function set(array $collection, $key, $value = null, $strict = false)
{
    if ($key === null) {
        return $collection;
    }

    $keys = \explode('.', $key);
    $key  = \array_shift($keys);

    if (\count($keys) === 0) {
        $collection[$key] = $value;
    } else {
        if (!\array_key_exists($key, $collection) || (!\is_array($collection[$key]) && $strict)) {
            $collection[$key] = [];
        } elseif (!\is_array($collection[$key])) {
            throw new \Exception(sprintf('Could not insert value %s into array because the value at key %s is no array.', $value, $key));
        }
        $collection[$key] = set($collection[$key], implode('.', $keys), $value);
    }

    return $collection;
}
