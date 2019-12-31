<?php

namespace collections;

/**
 * Get an iterator from an object that supports iterators.
 *
 * @param \Iterator|\IteratorAggregate $input
 *
 * @throws \InvalidArgumentException
 * @throws \Exception
 *
 * @return \Traversable
 */
function getIterator($input)
{
    if ($input instanceof \Iterator) {
        return $input;
    }

    if ($input instanceof \IteratorAggregate) {
        return $input->getIterator();
    }

    throw new \InvalidArgumentException('$input should implement the Iterator or IteratorAggregate interface');
}
