<?php

/*                                                 *\
 *                  [Bottomline]                   *
 *                                                 *
 ___________________________________________________
 ***************************************************

 ** Arrays
 compact, difference, findIndex, findLastIndex,
 first, flatten, indexOf, lastIndexOf, range,
 remove, filter, union, uniq, zip

 ** Chaining
 tap

 ** Collections
 at, contains, pluck, find, findLast, map

 ** Functions

 ** Objects

 ** Utilities

 *************************************************** 
 * __ v0.0.1                                       *
 * __ is licensed under the MIT license            *
 * Copyright (c) 2014 Maciej Czyżewski             *
\***************************************************/

/** Returns an instance of __ for OO-style calls (Object-Oriented) */
function __($object = null) 
{
    return new __($object);
}

/** 'Given enough eyeballs, all bugs are shallow' -- Eric Raymond */
class __
{

    /* ==========================================================================
       Variables
       ========================================================================== */

    private static $__ = null;

    /* ==========================================================================
       Functions
       ========================================================================== */

    /* Arrays
       ========================================================================== */

    /**
     * Creates an array with all falsey values removed.
     *
     * The values false, null, 0, "", undefined, and NaN are all falsey.
     *
     * Arguments:
     * (Array): The array to compact.
     *
     * Returns:
     * (Array): Returns a new array of filtered values.
     *
     * @arrays @compact
     */
    private function __compact($array = null)
    {
        $result = array();

        foreach ($array as $value) {
            if($value){
                array_push($result, $value);
            }
        }

        return $result;
    }

    /**
     * Creates an array excluding all values of the provided arrays.
     *
     * Using strict equality for comparisons, i.e. ===.
     *
     * Arguments:
     * (Array): The array to process.
     * (Array): The arrays of values to exclude.
     *
     * Returns:
     * (Array): Returns a new array of filtered values.
     *
     * @arrays @difference
     */
    private function __difference($array = null, $values = null)
    {
        $result = array();

        $index = -1;
        $length = count($array);

        while (++$index < $length){
            $value = $array[$index];
            if (self::indexOf($values, $value) < 0){
                array_push($result, $value);
            }
        }

        return $result;
    }

    /**
     * This method is like @find except that it returns
     * the index of the first element.
     *
     * That passes the callback check, instead of the element itself.
     *
     * Arguments:
     * (Array): The array to search.
     * (Function|Object|String): The function called per iteration. 
     * 
     * Returns:
     * (Number): Returns the index of the found element, else -1.
     *
     * @arrays @findIndex
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __findIndex($array = null, $iterator = null)
    {
        $index = -1;
        $length = count($array);

        while (++$index < $length) {
            if (call_user_func($iterator, $array[$index])) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * This method is like @findIndex except that it iterates
     * over elements of a collection from right to left.
     *
     * That passes the callback check, instead of the element itself.
     *
     * Arguments:
     * (Array): The array to search.
     * (Function|Object|String): The function called per iteration. 
     * 
     * Returns:
     * (Number): Returns the index of the found element, else -1.
     *
     * @arrays @findLastIndex
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __findLastIndex($array = null, $iterator = null)
    {
        $index = count($array);

        while (--$index > -1) {
            if (call_user_func($iterator, $array[$index])) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * Gets the first element or first n elements of an array.
     *
     * That passes the callback check, instead of the element itself.
     *
     * Arguments:
     * (Array): The array to search.
     * (Number): The number of elements to return.
     * (Function|Object|String): The function called per iteration. 
     * 
     * Returns:
     * (Array): Returns the first element(s) of array.
     *
     * @arrays @first
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __first($array = null, $limit = 1, $iterator = null)
    {
        $result = array();

        $index = -1;
        $length = count($array);

        if( $iterator == null ){
            while (++$index < $limit) {
                {
                    array_push($result, $array[$index]);
                }
            }
        }else{
            while (++$index < $length && count($result) < $limit) {
                if (call_user_func($iterator, $array[$index])) {
                    array_push($result, $array[$index]);
                }
            }            
        }

        return $result;
    }

    /**
     * Flattens a nested array (the nesting can be to any depth).
     *
     * Arguments:
     * (Array): The array to flatten.
     * 
     * Returns:
     * (Array): Returns a new flattened array.
     *
     * @arrays @flatten
     */
    private function __flatten($array = null)
    {
        $result = array();

        array_walk_recursive($array, function($value) use (&$result) { $result[] = $value; });

        return $result;
    }

    /**
     * Gets the index at which the first occurrence of value is found.
     *
     * Using strict equality for comparisons, i.e. ===. 
     *
     * Arguments:
     * (Array): The array to search.
     * 
     * Returns:
     * (Number): Returns the index of the matched value or -1.
     *
     * @arrays @indexOf
     *
     * TODO: If the array is already sorted providing true, 
     *   will run a faster binary search. (Now it's slow!)
     */
    private function __indexOf($array = null, $value = null)
    {
        $index = -1;
        $length = count($array);

        while (++$index < $length){
            if ($array[$index] === $value){
                return $index;
            }
        }
        
        return -1;
    }

    /**
     * Gets the last element or last n elements of an array.
     *
     * That passes the callback check, instead of the element itself.
     *
     * Arguments:
     * (Array): The array to search.
     * (Number): The number of elements to return.
     * (Function|Object|String): The function called per iteration. 
     * 
     * Returns:
     * (Array): Returns the last element(s) of array.
     *
     * @arrays @last
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __last($array = null, $limit = 1, $iterator = null)
    {

        $result = array();

        $index = $length = count($array);

        if( $iterator == null ){
            while (--$index > $length - $limit - 1) {
                {
                    array_push($result, $array[$index]);
                }
            }
        }else{
            while (--$index > -1 && count($result) < $limit) {
                if (call_user_func($iterator, $array[$index])) {
                    array_push($result, $array[$index]);
                }
            }            
        }

        return $result;
    }

    /**
     * Gets the index at which the last occurrence of value is found.
     *
     * Using strict equality for comparisons, i.e. ===. 
     *
     * Arguments:
     * (Array): The array to search.
     * 
     * Returns:
     * (Number): Returns the index of the matched value or -1.
     *
     * @arrays @lastIndexOf
     *
     * TODO: If the array is already sorted providing true, 
     *   will run a faster binary search. (Now it's slow!)
     */
    private function __lastIndexOf($array = null, $value = null)
    {
        $index = count($array);

        while (--$index > -1) {
            if ($array[$index] === $value){
                return $index;
            }
        }
        
        return -1;
    }

    /**
     * Creates an array of numbers (positive and/or negative)
     * progressing from start up to but not including end.
     *
     * If start is less than stop a zero-length range is 
     * created unless a negative step is specified.
     *
     * Arguments:
     * (Number): The start of the range.
     * (Number): The end of the range.
     * (Number): The value to increment or decrement by.
     * 
     * Returns:
     * (Array): Returns a new range array.
     *
     * @arrays @range
     *
     * TODO: Add negative progressing. (Now it's only positive)
     */
    private function __range($start = 0, $end = 0, $step = 1)
    {
        $result = array();

        $index = -1;
        $length = abs($start - $end);

        while (++$index < $length / $step) {
            array_push($result, $start + ($index) * $step);
        }

        return $result;        
    }

    /**
     * Removes all elements from an array that the callback
     * returns truey for and returns an array of removed elements. 
     *
     * Arguments:
     * (Array): The array to modify.
     * (Function|Object|String): The function called per iteration.
     * 
     * Returns:
     * (Array): Returns a new array of removed elements.
     *
     * @arrays @remove
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __remove($array = null, $iterator = null)
    {
        $result = array();

        $index = -1;
        $length = count($array);

        while (++$index < $length) {
            if (!call_user_func($iterator, $array[$index])) {
                array_push($result, $array[$index]);
            }
        }

        return $result;
    }
    
    /**
     * Iterates over elements of a collection, returning an 
     * array of all elements the callback returns truey for. 
     *
     * Arguments:
     * (Array): The array to iterate over.
     * (Function|Object|String): The function called per iteration.
     * 
     * Returns:
     * (Array): Returns a new array of elements that passed the callback check.
     *
     * @arrays @filter
     *
     * TODO: Repair broken callbacks. (Now it's only a function!)
     */
    private function __filter($array = null, $iterator = null)
    {
        $result = array();

        $index = -1;
        $length = count($array);

        while (++$index < $length) {
            if (call_user_func($iterator, $array[$index])) {
                array_push($result, $array[$index]);
            }
        }

        return $result;
    }

    /**
     * Creates an array of unique values, in order, of the provided arrays.
     *
     * Using strict equality for comparisons, i.e. ===.
     *
     * Arguments:
     * [Args] (Array): The arrays to inspect.
     * 
     * Returns:
     * (Array): Returns an array of combined values.
     *
     * @arrays @union
     */
    private function __union()
    {
        $result = array();

        $array = func_get_args();

        foreach ($array as $key => $value) {
            $result = array_merge($result, $value);
        }

        return self::__uniq($result);
    }

    /**
     * Creates a duplicate-value-free version of an array.
     *
     * Using strict equality for comparisons, i.e. ===.
     *
     * Arguments:
     * (Array): The array to process.
     * 
     * Returns:
     * (Array): Returns a duplicate-value-free array.
     *
     * @arrays @uniq
     */
    private function __uniq($array = null)
    {
        $result = array();

        $result = array_values(array_unique($array));

        return $result;
    }

    /**
     * Creates an array of grouped elements, the first of
     * which contains the first elements of the given arrays,
     * the second of which contains the second elements of 
     * the given arrays, and so on.
     *
     * Arguments:
     * [Args] (Array): Arrays to process.
     * 
     * Returns:
     * (Array): Returns a new array of grouped elements.
     *
     * @arrays @zip
     * 
     * TODO: Create new function @unzip (Now it's only @zip)
     */
    private function __zip()
    {
        $result = array();

        $array = func_get_args();

        foreach ($array as $key => $value) {
            foreach ($value as $k => $p) {
                $result[$k][] = $p;
            }
        }

        return $result;
    }

    /* Chaining
       ========================================================================== */

    // [object], [iterator]
    private function __tap($object, $iterator)
    {
        $result = array();

        $result = call_user_func($iterator, $object);

        return $result;
    }

    /* Collections
       ========================================================================== */
    
    // [array], [indexes]
    private function __at($array = null, $indexes = null) 
    {    
        $result = array();

        foreach($indexes as $key => $index) {
            array_push($result, $array[$index]);
        }

        return $result;
    }

    // [array], [value]
    private function __contains($array = null, $value = null) 
    {    
        $result = array();

        if( self::__indexOf($array, $value) < 0 ){
            return false;
        }else{
            return true;
        }

        return $result;
    }

    // [array], [field]
    private function __pluck($array = null, $field = null, $preserve_keys = TRUE, $remove_nomatches = TRUE )
    {
        $result = array();

        foreach ( $array as $key => $value ) {
            if ( is_object( $value ) ) {
                if ( isset( $value->{$field} ) ) {
                    if ( $preserve_keys ) {
                        $result[$key] = $value->{$field};
                    } else {
                        $result[] = $value->{$field};
                    }
                } else if ( ! $remove_nomatches ) {
                    $result[$key] = $value;
                }
            } else {
                if ( isset( $value[$field] ) ) {
                    if ( $preserve_keys ) {
                        $result[$key] = $value[$field];
                    } else {
                        $result[] = $value[$field];
                    }
                } else if ( ! $remove_nomatches ) {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }

    // [array], [iterator]
    private function __find($array = null, $iterator = null) 
    {    
        $result = array();

        $result = $array[self::__findIndex($array, $iterator)];

        return $result;
    }

    // [array], [iterator]
    private function __findLast($array = null, $iterator = null) 
    {    
        $result = array();

        $result = $array[self::__findLastIndex($array, $iterator)];

        return $result;
    }

    // [array], [iterator]
    private function __map($array = null, $iterator = null) 
    {    
        $result = array();

        foreach($array as $key => $value) {
            $result[$key] = call_user_func($iterator, $value);
        }

        return $result;
    }
    
    /* Functions
       ========================================================================== */
    
    /* Objects
       ========================================================================== */
    
    /* Utilities
       ========================================================================== */

    /* ==========================================================================
       Initialize
       ========================================================================== */
    
    /**
     * 1. Save arguments to global varieble.
     * 2. Call to method, prepare with prefix `__`.
     */

    /* Call to method by function or OO-style */
    public function __construct($arguments)
    {
        self::$__ = $arguments; /* 1 */
    }

    public function __call($method, $arguments = null)
    {
        return call_user_func_array(__CLASS__ . '::__' . $method, array(self::$__)); /* 2 */
    }

    /* Call to method by static */
    public static function __callStatic($method, $arguments)
    {
        self::$__ = $arguments; /* 1 */
        return call_user_func_array(__CLASS__ . '::__' . $method, self::$__); /* 2 */
    }

}
