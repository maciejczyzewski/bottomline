<?php

namespace collections;

// TODO Place in .internal folder. (Something or somewhere not intented to be used
// externally: these are internal helpers).
function _universal_set($collection, $key, $value) {
    $set_object = function ($object, $key, $value) {
        $newObject = clone $object;
        $newObject->$key = $value;
        return $newObject;
    };
    $set_array = function ($array, $key, $value) {
        $array[$key] = $value;
        return $array;
    };
    $setter = \__::isObject($collection) ? $set_object : $set_array;
    return call_user_func_array($setter, [$collection, $key, $value]);
}

/**
 * Return a new collection with the item set at index to given value.
 * Index can be a path of nested indexes.
 *
 * If a portion of path doesn't exist, it's created. Arrays are created for missing
 * index in an array; objects are created for missing property in an object.
 *
 ** __::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
 ** // → '['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]'
 *
 * @param array|object $collection collection of values
 * @param string  $path key or index
 * @param mixed   $value the value to set at position $key
 * @throws \Exception if the path consists of a non collection and strict is set to false
 *
 * @return array|object the new collection with the item set
 *
 */
function set($collection, $path, $value = null)
{
    if ($path === null) {
        return $collection;
    }

    $portions = \__::split($path, '.', 2);
    $key  = $portions[0];

    if (\count($portions) === 1) {
        return _universal_set($collection, $key, $value);
    }
    // Here we manage the case where the portion of the path points to nothing,
    // or to a value that does not match the type of the source collection
    // (e.g. the path portion 'foo.bar' points to an integer value, while we
    // want to set a string at 'foo.bar.fun'. We first set an object or array
    //  - following the current collection type - to 'for.bar' before setting
    // 'foo.bar.fun' to the specified value).
    if (
        !\__::has($collection, $key)
        || (\__::isObject($collection) && !\__::isObject(\__::get($collection, $key)))
        || (\__::isArray($collection) && !\__::isArray(\__::get($collection, $key)))
    ) {
        $collection = _universal_set($collection, $key, \__::isObject($collection) ? new \stdClass : []);
    }
    return _universal_set($collection, $key, set(\__::get($collection, $key), $portions[1], $value));
}
