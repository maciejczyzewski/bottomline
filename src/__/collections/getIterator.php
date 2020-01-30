<?php

namespace collections;

/**
 * Get an iterator from an object that supports iterators; including generators.
 *
 * @param \Traversable $input
 *
 * @throws \InvalidArgumentException when $input does not implement `\Iterator` or `\IteratorAggregate`
 * @throws \Exception when `\IteratorAggregate::getIterator()` throws an exception
 *
 * @see https://www.php.net/manual/en/language.generators.overview.php#language.generators.object
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
