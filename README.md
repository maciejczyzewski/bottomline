<div align="center">
  <img alt="Bottomline logo" src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot-1.png">
</div>


# bottomline
[![Build Status](https://travis-ci.org/MaciejCzyzewski/bottomline.png)](https://travis-ci.org/MaciejCzyzewski/bottomline)
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

##### [__::append](src/__/arrays/append.php)
```php
__::append([1, 2, 3], 4);
// >> [1, 2, 3, 4]
```

##### [__::compact](src/__/arrays/compact.php)
Returns a copy of the array with falsy values removed.
```php
__::compact([0, 1, false, 2, '', 3]);
// >> [1, 2, 3]
```

##### [__::flatten](src/__/arrays/flatten.php)
Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
```php
__::flatten([1, 2, [3, [4]]], [flatten]);
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

### Chaining

`coming soon...`


### Collections

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
```php
__::get(['foo' => ['bar' => 'ter']], 'foo.bar');
// >> 'ter'
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

### Utilities


## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:


## License

See LICENSE file in this repository.
