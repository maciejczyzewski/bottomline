<?php

namespace __\TestHelpers;

class MockIteratorAggregate implements \IteratorAggregate
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
