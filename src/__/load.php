<?php

namespace __;

/*                                                 *\
 *                   bottomline                    *
 *                                                 *
 ___________________________________________________
 ***************************************************

 ** Arrays                                       [6]
 ** Chaining                                     [3]
 ** Collections                                  [9]
 ** Functions                                    [0]
 ** Objects                                      [7]
 ** Utilities                                    [0]

 ***************************************************
 * bottomline v0.0.5                               *
 * bottomline is licensed under the MIT license    *
 * Copyright (c) 2014 Maciej A. Czyzewski          *
\***************************************************/

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new \Exception('Your PHP installation is too old. Bottomline requires at least PHP 5.4.0', 1);
}

/** 'Given enough eyeballs, all bugs are shallow' -- Eric Raymond */

/**
 * @method static array append(array $input, $item) <code>__::append([1, 2, 3], 4)</code> >> [1, 2, 3, 4]
 * @method static array compact(array $input) Returns a copy of the array with falsy values removed. <code>__::compact([0, 1, false, 2, '', 3])</code> >> [1, 2, 3]
 * @method static array flatten(array $input, bool $shallow = false) Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
 * @method static array patch(array $input, array $patches) Patches array with list of xpath-value pairs.
 * @method static array prepend(array $input, $item)
 * @method static array randomize(array $input) Returns shuffled array.
 * @method static array range(int $startOrCount, int $stop = null, int $step = null) Returns an array of integers from start to stop (exclusive) by step.
 * @method static array repeat($input, int $times = 0) Returns an array of input repeated $times times.
 *
 * @method static array filter(array|\Traversable $input, \Closure $func = null) Returns the values in the collection that pass the truth test.
 * @method static array get(array|\Traversable $input, string $path, \Closure|mixed $default = null)
 * @method static array|mixed first(array $input, int $count = null) Gets the first element of an array. Passing n returns the first n elements.
 * @method static array|mixed last(array $input, int $count = null) Gets the last element of an array. Passing n returns the last n elements.
 * @method static array map(array $input, \Closure $func = null) Returns an array of values by mapping each in collection through the iterator.
 * @method static array max(array|\Traversable $input) Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.
 * @method static array min(array|\Traversable $input) Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.
 * @method static array pluck(array|\Traversable $input, string $key = '') Returns an array of values belonging to a given property of each item in a collection.
 * @method static array where(array|\Traversable $input, mixed $itemParams = '')
 *
 * @method static array slug(string $input, array $options = []) Default options: <code>array('delimiter' => '-', 'limit' => null, 'lowercase' => true, 'replacements' => array(), 'transliterate' => true)</code>
 * @method static array truncate(string $input, int $wordsCount)
 * @method static array urlify(string $input) <code> __::urlify('I love https://google.com') </code> >> 'I love <a href="https://google.com">google.com</a>'
 *
 * @method static bool isArray($var)
 * @method static bool isEmail($var)
 * @method static bool isFunction($var)
 * @method static bool isNull($var)
 * @method static bool isNumber($var)
 * @method static bool isObject($var)
 * @method static bool isString($var)
 *
 * @method static int now()
 */
class __
{
    private static $modules = [
        'arrays',
        'chaining',
        'collections',
        'functions',
        'objects',
        'utilities'
    ];

    private static $functions = [];

    public static function __callStatic($name, $arguments)
    {
        return self::__loader($name, $arguments);
    }

    public function __call($name, $arguments)
    {
        return self::__loader($name, $arguments);
    }

    static public function __loader($name, $arguments)
    {
        if (count(self::$functions) == 0) {
            foreach (self::$modules as $key => $value) {
                foreach (glob(__DIR__ . '/' . $value . '/*.php', GLOB_BRACE) as $function) {
                    $path  = explode('.', str_replace(__DIR__ . '/', '', $function));
                    $alias = str_replace('/', '\\', array_shift($path));

                    if (!function_exists($alias)) {
                        self::$functions[] = $alias;
                        require $function;
                    }
                }
            }
        }

        foreach (self::$functions as $key => $value) {
            if (strpos($value, $name)) {
                return call_user_func_array($value, $arguments);
            }
        }

        throw new \Exception('Invalid function: ' . $name);
    }
}
