<?php

namespace __\Test\Utilities;

class ArrayAccessible implements \ArrayAccess
{
    private $content = [];

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->content);
    }

    public function offsetGet($offset)
    {
        return $this->content[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->content[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->content[$offset]);
    }
}
