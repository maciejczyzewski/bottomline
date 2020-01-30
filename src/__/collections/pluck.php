<?php

namespace collections;

/**
 * Returns an array of values belonging to a given property of each item in a collection.
 *
 * **Usage**
 *
 * ```php
 * $a = [
 *     ['foo' => 'bar',  'bis' => 'ter' ],
 *     ['foo' => 'bar2', 'bis' => 'ter2'],
 * ];
 *
 * __::pluck($a, 'foo');
 * ```
 *
 * **Result**
 *
 * ```
 * ['bar', 'bar2']
 * ```
 *
 * @since 0.2.0 added support for iterables
 *
 * @param iterable|\stdClass $collection Array or object that can be converted to array
 * @param string             $property   property name
 *
 * @return array
 */
function pluck($collection, $property)
{
    $result = \array_map(function ($value) use ($property) {
        if (is_array($value) && isset($value[$property])) {
            return $value[$property];
        } elseif (\is_object($value) && isset($value->{$property})) {
            return $value->{$property};
        }

        foreach (\__::split($property, \__::DOT_NOTATION_DELIMITER) as $segment) {
            if (\is_object($value)) {
                if (isset($value->{$segment})) {
                    $value = $value->{$segment};
                } else {
                    return null;
                }
            } else {
                if (isset($value[$segment])) {
                    $value = $value[$segment];
                } else {
                    return null;
                }
            }
        }

        return $value;
    }, (array)$collection);

    return \array_values($result);
}
