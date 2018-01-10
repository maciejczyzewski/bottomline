<div align="center">
  <img alt="Bottomline logo" src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot-1.png">
</div>


# bottomline
[![Build Status](https://travis-ci.org/maciejczyzewski/bottomline.png)](https://travis-ci.org/maciejczyzewski/bottomline)
[![PHP version](https://badge.fury.io/ph/maciejczyzewski%2Fbottomline.svg)](http://badge.fury.io/ph/maciejczyzewski%2Fbottomline)


## Table of Contents:
- [Introduction](#introduction)
- [Installation](#installation)
- [Structure](#structure)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)


## Requirements

```ini
; php.ini
extension=php_mbstring.dll
```

## Introduction

bottomline is a PHP utility library, similar to Underscore/Lodash, that utilizes namespaces and dynamic autoloading to improve performance.

---

**NOTE:** bottomline is not currently in feature parity with Underscore/Lodash. Review the [contributing](#contributing) section for more information.

---

### Benchmarks

<div align="center">
  <img src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot-2.png"/>
</div>


## Installation

Install bottomline as described in the methods below:


### via Composer and packagist

[Packagist repo](https://packagist.org/packages/maciejczyzewski/bottomline)

Put the require statement in your `composer.json` file and run `composer install`:

```json
{
    "require": {
        "maciejczyzewski/bottomline": "*"
    }
}
```


### via File Include

Put the require statement in your code:

```php
require 'bottomline/bottomline.php';
```


## Usage

### Arrays

##### [__::append](src/__/arrays/append.php)
```php
__::append([1, 2, 3], 4);
// >> [1, 2, 3, 4]
```

##### [__::chunk](src/__/arrays/chunk.php)
Creates an array of elements split into groups the length of size. If an array can't be split evenly, the final chunk will be the remaining elements.
```php
__::chunk([1, 2, 3, 4, 5], 3);
// >> [[1, 2, 3], [4, 5]]
```

##### [__::compact](src/__/arrays/compact.php)
Returns a copy of the array with falsy values removed.
```php
__::compact([0, 1, false, 2, '', 3]);
// >> [1, 2, 3]
```

##### [__::drop](src/__/arrays/drop.php)
Creates a slice of array with n elements dropped from the beginning.
```php
__::drop(1, 2, 3], 2);
// >> [3]
```

##### [__::flatten](src/__/arrays/flatten.php)
Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
```php
__::flatten([1, 2, [3, [4]]], true);
// >> [1, 2, 3, 4]
```

##### [__::patch](src/__/arrays/patch.php)
Patches array with list of xpath-value pairs.
```php
__::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
// >> ['addr' => ['country' => 'CA', 'zip' => 54321]]
```

##### [__::prepend](src/__/arrays/prepend.php)
```php
__::prepend([1, 2, 3], 4);
// >> [4, 1, 2, 3]
```

##### [__::randomize](src/__/arrays/randomize.php)
Returns shuffled array ensuring no item remains in the same position.
```php
__::randomize(1, 2, 3, 4);
// >> [4, 3, 1, 2]
```

##### [__::range](src/__/arrays/range.php)
Returns an array of integers from start to stop (exclusive) by step.
```php
__::range(1, 10, 2);
// >> [1, 3, 5, 7, 9]
```

##### [__::repeat](src/__/arrays/repeat.php)
```php
__::repeat('foo', 3);
// >> ['foo', 'foo', 'foo']
```

### Sequences

#### [__::chain](src/__/sequences/chain.php)
```php
__::chain([1, 2, 3, 0, null])
    ->compact()
    ->prepend(4)
    ->reduce(function($sum, $number) {
        return $sum + $number;
    }, 0)
    ->value();
// >> 10
```

### Collections

##### [__::ease](src/__/collections/ease.php)
Flattens a complex collection by mapping each ending leafs value to a key consisting of all previous indexes.
```php
__::ease(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]);
// >> '['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']'
```

##### [__::filter](src/__/collections/filter.php)
Returns the values in the collection that pass the truth test.
```php
$a = [
    ['name' => 'fred',   'age' => 32],
    ['name' => 'maciej', 'age' => 16]
];

__::filter($a, function($n) {
    return $n['age'] > 24;
});
// >> [['name' => 'fred', 'age' => 32]]
```

##### [__::first](src/__/collections/first.php)
Gets the first element of an array. Passing n returns the first n elements.
```php
__::first([1, 2, 3, 4, 5], 2);
// >> [1, 2]
```

##### [__::get](src/__/collections/get.php)
Get item of an array by index, aceepting nested index
```php
__::get(['foo' => ['bar' => 'ter']], 'foo.bar');
// >> 'ter'
```

##### [__::groupBy](src/__/collections/groupBy.php)
Group an array of objects or arrays based on a given key.
```php
$a = [
    ['name' => 'maciej',    'continent' => 'Europe'],
    ['name' => 'yoan',      'continent' => 'Europe'],
    ['name' => 'brandtley', 'continent' => 'North America'],
];

__::groupBy($a, 'continent');
// >> [
//   'Europe' => [
//     ['name' => 'maciej', 'continent' => 'Europe'],
//     ['name' => 'yoan', 'continent' => 'Europe'],
//   ],
//   'North America' => [ ['name' => 'brandtley', 'continent' => 'North America'] ]
// ]
```

##### [__::has](src/__/collections/has.php)
Returns true if the collection contains the requested key.
```php
__::has(['foo' => 'bar', 'foz' => 'baz'], 'foo');
// >> true
```

##### [__::hasKeys](src/__/collections/hasKeys.php)
Returns if $input contains all requested $keys. If $strict is true it also checks if $input exclusively contains the given $keys.
```php
__::hasKeys(['foo' => 'bar', 'foz' => 'baz'], ['foo', 'foz']);
// >> true
```

##### [__::isEmpty](src/__/collections/isEmpty.php)
Check if value is an empty array or object.
```php
__::isEmpty([]);
// >> true
__::isEmpty(new stdClass());
// >> true
```

##### [__::last](src/__/collections/last.php)
Gets the last element of an array. Passing n returns the last n elements.
```php
__::last([1, 2, 3, 4, 5], 2);
// >> [4, 5]
```

##### [__::map](src/__/collections/map.php)
Returns an array of values by mapping each in collection through the iterator.
```php
__::map([1, 2, 3], function($n) {
    return $n * 3;
});
// >> [3, 6, 9]
```

##### [__::mapKeys](src/__/collections/mapKeys.php)
Transforms the keys in a collection by running each key through the iterator
```php
__::mapKeys(['x' => 1], function($key, $value, $collection) {
    return "{$key}_{$value}";
});
// >> ['x_1' => 1]

__::mapKeys(['x' => 1], function($key) {
    return strtoupper($key);
});
// >> ['X' => 3]

__::mapKeys(['x' => 1])
// >> ['x' => 1]

```

##### [__::mapValues](src/__/collections/mapValues.php)
Transforms the values in a collection by running each value through the iterator
```php
__::mapValues(['x' => 1], function($value, $key, $collection) {
    return "{$key}_{$value}";
});
// >> ['x' => 'x_1']

__::mapValues(['x' => 1], function($value) {
    return $value * 3;
});
// >> ['x' => 3]

__::mapValues(['x' => 1])
// >> ['x' => 1]
```

##### [__::max](src/__/collections/max.php)
Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.
```php
__::max([1, 2, 3]);
// >> 3
```

##### [__::min](src/__/collections/min.php)
Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.
```php
__::min([1, 2, 3]);
// >> 1
```

##### [__::pluck](src/__/collections/pluck.php)
Returns an array of values belonging to a given property of each item in a collection.
```php
$a = [
    ['foo' => 'bar',  'bis' => 'ter' ],
    ['foo' => 'bar2', 'bis' => 'ter2'],
];

__::pluck($a, 'foo');
// >> ['bar', 'bar2']
```

##### [__::reduce](src/__/collections/reduce.php)
Reduces a collection to a value which is the accumulator result of running each
element in the collection thru an iteratee function, where each successive
invocation is supplied the return value of the previous.
```php
__::reduce([1, 2], function ($sum, $number) {
    return $sum + $number;
}, 0);
// >> 3
```

##### [__::set](src/__/collections/set.php)
Return a new collection with the item set at index to given value. Index can be a path.
```php
__::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
// >> ['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]
```

##### [__::pick](src/__/collections/pick.php)
Returns an array having only keys present in the given path list.
```php
__::pick(['a' => 1, 'b' => ['c' => 3, 'd' => 4]], ['a', 'b.d']);
// → ['a' => 1, 'b' => ['d' => 4]]
```

##### [__::unease](src/__/collections/unease.php)
Builds a multidimensional collection out of a hash map using the key as indicator where to put the value.
```php
__::unease(['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']);
// >> ['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]
```

##### [__::where](src/__/collections/where.php)
```php
$a = [
    ['name' => 'fred',   'age' => 32],
    ['name' => 'maciej', 'age' => 16]
];

__::where($a, ['age' => 16]);
// >> [['name' => 'maciej', 'age' => 16]]
```

### Functions

##### [__::slug](src/__/chaining/slug.php)
```php
__::slug('Jakieś zdanie z dużą ilością obcych znaków!');
// >> 'jakies-zdanie-z-duza-iloscia-obcych-znakow'
```

##### [__::truncate](src/__/chaining/truncate.php)
```php
$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';
__::truncate($string);
// >> 'Lorem ipsum dolor sit amet, ...'
```

##### [__::urlify](src/__/chaining/urlify.php)
```php
__::urlify('I love https://google.com');
// >> 'I love <a href="https://google.com">google.com</a>'
```

### Objects

##### [__::isArray](src/__/objects/isArray.php)
```php
__::isArray([1, 2, 3]);
// >> true
```

##### [__::isEmail](src/__/objects/isEmail.php)
```php
__::isEmail('test@test.com');
// >> true
```

##### [__::isFunction](src/__/objects/isFunction.php)
```php
__::isFunction(function ($a) { return $a + 2; });
// >> true
```

##### [__::isNull](src/__/objects/isNull.php)
```php
__::isNull(null);
// >> true
```

##### [__::isNumber](src/__/objects/isNumber.php)
```php
__::isNumber(123);
// >> true
```

##### [__::isObject](src/__/objects/isObject.php)
```php
__::isObject('fred');
// >> false
```

##### [__::isString](src/__/objects/isString.php)
```php
__::isString('fred');
// >> true
```

##### [__::isCollection](src/__/objects/isCollection.php)
Returns true if the argument is a collection (that is an array or object).
```php
__::isCollection([1, 2, 3]);
// >> true
```

### Utilities

#### [__::identity](src/__/utilities/identity.php)
Returns the first argument it receives
```php
__::identity(1, 2, 3, 4)
// >> 1

__::identity()
// >> null
```

### Strings

##### [__::camelCase](src/__/strings/camelCase.php)
```php
__::camelCase('Foo Bar');
// >> 'fooBar'
```

##### [__::capitalize](src/__/strings/capitalize.php)
```php
__::capitalize('FRED');
// >> 'Fred'
```

##### [__::kebabCase](src/__/strings/kebabCase.php)
```php
__::kebabCase('Foo Bar');
// >> 'foo-bar'
```

##### [__::lowerCase](src/__/strings/lowerCase.php)
```php
__::lowerCase('fooBar');
// >> 'foo bar'
```

##### [__::lowerFirst](src/__/strings/lowerFirst.php)
```php
__::lowerFirst('Fred');
// >> 'fred'
```

##### [__::snakeCase](src/__/strings/snakeCase.php)
```php
__::snakeCase('Foo Bar');
// >> 'foo_bar'
```

##### [__::split](src/__/strings/split.php)
Split a string by string.
```php
__::split('github.com', '.');
// >> ['github', 'com']
```

##### [__::startCase](src/__/strings/startCase.php)
```php
__::startCase('fooBar');
// >> 'Foo Bar'
```

##### [__::toLower](src/__/strings/toLower.php)
```php
__::toLower('fooBar');
// >> 'foobar'
```

##### [__::toUpper](src/__/strings/toUpper.php)
```php
__::toUpper('fooBar');
// >> 'FOOBAR'
```

##### [__::upperCase](src/__/strings/upperCase.php)
```php
__::upperCase('fooBar');
// >> 'FOO BAR'
```

##### [__::upperFirst](src/__/strings/upperFirst.php)
```php
__::upperFirst('fred');
// >> 'Fred'
```

##### [__::words](src/__/strings/words.php)
```php
__::words('fred, barney, & pebbles');
// >> ['fred', 'barney', 'pebbles']
```

## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:

To run the tests, install PHPUnit with `make install-dev` and run the tests with `make test`.


## License

See LICENSE file in this repository.

## Thanks

* Yoan Tournade ([@MonsieurV](https://github.com/MonsieurV))
* Brandtley McMinn ([@bmcminn](https://github.com/bmcminn))
* Ivan Ternovtsiy ([@diaborn19](https://github.com/diaborn19))
* Tobias Seipke ([@nullpunkt](https://github.com/nullpunkt))
