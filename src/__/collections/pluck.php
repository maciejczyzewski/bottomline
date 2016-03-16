<?php

namespace collections;

/**
 * Returns an array of values belonging to a given property of each item in a collection.
 *
 * @param array  $collection rray
 * @param string $property property
 *
 * @return array|object
 *
 */
function pluck($collection = array(), $property = '')
{
    $plucked = \array_map(
      function ($value) use ($property) {
          return \collections\get($value, $property);
      }, (array)$collection
    );

    if (\objects\isObject($collection)) {
        $plucked = (object)$plucked;
    }

    return $plucked;
}
