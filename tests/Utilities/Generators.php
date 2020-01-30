<?php

namespace __\Test\Utilities;

abstract class Generators
{
    public static function integerGenerator($n = null)
    {
        for ($i = 0; $n === null || $i < $n; $i++) {
            yield $i;
        }
    }

    public static function createGeneratorFromIterable($iterable)
    {
        foreach ($iterable as $key => $value) {
            yield $key => $value;
        }
    }
}
