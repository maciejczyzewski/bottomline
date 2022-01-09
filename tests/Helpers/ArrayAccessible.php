<?php

namespace __\TestHelpers;

class ArrayAccessible implements \ArrayAccess
{
    private $content = [];

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->content);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->content[$offset];
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->content[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->content[$offset]);
    }
}
