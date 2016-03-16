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

bottomline is a PHP utility library, similar to Underscore/Lodash, that utilizes `namespace`s and dynamic auto loading to improve library performance.


### Project Structure

- `bottomline.php` is the entry point for the bottomline utility library
- All bottomline methods are stored in separate files within their respective `namespace` folder outlined in `/src/__`
- Tests reflect the `namespace` defined within the library and are processed using [phpunit testing](https://phpunit.de)
    + To test bottomline, [install phpunit](https://phpunit.de/getting-started.html) and in the terminal, run `phpunit`

```bash
/bottomline
├── /images
│   └── (place relevant graphics in this folder)
├── /src
│   └── /__
│       ├── /arrays
│       ├── /collections
│       ├── /functions
│       ├── /objects
│       ├── /utilities
│       └── load.php        # (autoloader script for all bottomline methods)
├── /tests
│   ├── arrays.php
│   ├── chaining.php
│   ├── collections.php
│   ├── functions.php
│   ├── objects.php
│   └── utilities.php
├── .gitignore
├── .travis.yaml
├── bottomline.php
├── composer.json
├── phpunit.xml
├── LICENSE
└── README.md
```

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
        ...
        "maciejczyzewski/bottomline": "*"
        ...
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

##### [`__::append()`](src/__/arrays/append.php)
```php
__::append([1, 2, 3], 4);
// >> [1, 2, 3, 4]
```

##### [`__::compact()`](src/__/arrays/compact.php)
Returns a copy of the array with falsy values removed.
```php
__::compact([0, 1, false, 2, '', 3]);
// >> [1, 2, 3]
```

##### [`__::flatten()`](src/__/arrays/flatten.php)
Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
```php
__::flatten([1, 2, [3, [4]]], [flatten]);
// >> [1, 2, 3, 4]
```

##### [`__::patch()`](src/__/arrays/patch.php)
Patches array with list of xpath-value pairs.
```php
__::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
// >> ['addr' => ['country' => 'CA', 'zip' => 54321]]
```

##### [`__::prepend()`](src/__/arrays/prepend.php)
```php
__::prepend([1, 2, 3], 4);
// >> [4, 1, 2, 3]
```

##### [`__::range()`](src/__/arrays/range.php)
Returns an array of integers from start to stop (exclusive) by step.
```php
__::range(1, 10, 2);
// >> [1, 3, 5, 7, 9]
```

##### [`__::repeat($val, $n)`](src/__/arrays/repeat.php)
Returns an array of `$n` length with each index containing the provided value.
```php
__::repeat('foo', 3);
// >> ['foo', 'foo', 'foo']
```

### Chaining

`coming soon...`


### Collections

##### [`__::filter($array, callback($n))`](src/__/collections/filter.php)
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

##### [`__::first($array, [$n])`](src/__/collections/first.php)
Gets the first element of an array. Passing n returns the first n elements.
```php
__::first([1, 2, 3, 4, 5], 2);
// >> [1, 2]
```

##### [`__::get($array, JSON $string)`](src/__/collections/get.php)
```php
__::get(['foo' => ['bar' => 'ter']], 'foo.bar');
// >> 'ter'
```

##### [`__::last($array, [$n])`](src/__/collections/last.php)
Gets the last element of an array. Passing n returns the last n elements.
```php
__::last([1, 2, 3, 4, 5], 2);
// >> [4, 5]
```

##### [`__::map($array, callback($n))`](src/__/collections/map.php)
Returns an array of values by mapping each in collection through the iterator.
```php
__::map([1, 2, 3], function($n) {
    return $n * 3;
});
// >> [3, 6, 9]
```

##### [`__::max($array)`](src/__/collections/max.php)
Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.
```php
__::max([1, 2, 3]);
// >> 3
```

##### [`__::min($array)`](src/__/collections/min.php)
Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.
```php
__::min([1, 2, 3]);
// >> 1
```

##### [`__::pluck($array, $property)`](src/__/collections/pluck.php)
Returns an array of values belonging to a given property of each item in a collection.
```php
$a = [
    ['foo' => 'bar',  'bis' => 'ter' ],
    ['foo' => 'bar2', 'bis' => 'ter2'],
];

__::pluck($a, 'foo');
// >> ['bar', 'bar2']
```

##### [`__::where($array, $parameters[])`](src/__/collections/where.php)
Returns a collection of objects matching the given array of parameters.
```php
$a = [
    ['name' => 'fred',   'age' => 32],
    ['name' => 'maciej', 'age' => 16]
];

__::where($a, ['age' => 16]);
// >> [['name' => 'maciej', 'age' => 16]]
```


### Functions

##### [`__::slug($string, [array $options])`](src/__/functions/slug.php)
```php
__::slug('Jakieś zdanie z dużą ilością obcych znaków!');
// >> 'jakies-zdanie-z-duza-iloscia-obcych-znakow'

$options = [
    'delimiter' => '-',
    'limit' => 30,
    'lowercase' => true,
    'replacements' => array(),
    'transliterate' => true
]

__::slug('Something you don\'t know about know about Jackson', $options);
// >> 'something-you-dont-know-about'
```

##### [`__::truncate($string, [$limit=40])`](src/__/functions/truncate.php)
```php
$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';
__::truncate($string);
// >> 'Lorem ipsum dolor sit amet, consectetur...'

__::truncate($string, 60);
// >> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pel...'
```

##### [`__::urlify($string)`](src/__/functions/urlify.php)
```php
__::urlify('I love https://google.com');
// >> 'I love <a href="https://google.com">google.com</a>'
```


### Objects

##### [`__::isArray($array)`](src/__/objects/isArray.php)
```php
__::isArray([1, 2, 3]);
// >> true

__::isArray(123);
// >> false
```

##### [`__::isFunction($string)`](src/__/objects/isFunction.php)
```php
__::isFunction(function ($a) { return $a + 2; });
// >> true
```

##### [`__::isNull($null)`](src/__/objects/isNull.php)
```php
__::isNull(null);
// >> true
```

##### [`__::isNumber($int|$float)`](src/__/objects/isNumber.php)
```php
__::isNumber(123);
// >> true
```

##### [`__::isObject($object)`](src/__/objects/isObject.php)
```php
__::isObject('fred');
// >> false
```

##### [`__::isString($string)`](src/__/objects/isString.php)
```php
__::isString('fred');
// >> true
```


### Utilities
##### [`__::isEmail($string)`](src/__/objects/isEmail.php)
```php
__::isEmail('test@test.com');
// >> true

__::isEmail('test_test.com');
// >> false
```

##### [`__::now()`](src/__/utilities/now.php)
Wrapper of the [`time()`](http://php.net/manual/en/function.time.php) function that returns the current offset in seconds since the Unix Epoch.
```php
__::now();
// >> 1417546029
```

##### [`__::stringContains($needle, $haystack, [$offset])`](src/__/utilities/stringContains.php)
Wrapper of the [`time()`](http://php.net/manual/en/function.time.php) function that returns the current offset in seconds since the Unix Epoch.
```php
__::stringContains('waffle', 'wafflecone');
// >> true
```

## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:


## License

See LICENSE file in this repository.


## Thanks

* Brandtley McMinn ([@bmcminn](https://github.com/bmcminn))
