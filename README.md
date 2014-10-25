<div align="center">
  <img src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot-1.png"/>
</div>

> It can be used as port of _lodash.js_ or _underscore.js_.

# bottomline [![Build Status](https://travis-ci.org/MaciejCzyzewski/bottomline.png)](https://travis-ci.org/MaciejCzyzewski/bottomline) [![PHP version](https://badge.fury.io/ph/maciejczyzewski%2Fbottomline.svg)](http://badge.fury.io/ph/maciejczyzewski%2Fbottomline)

Useful feature pack.

## Introduction

It's a full-on PHP manipulation utility-belt that provides support for the usual functional.

#### More reading:

- [Installation](#installation): Step-by-step instructions for getting bottomline running on your computer.
- [Structure](#structure): Explanation of bottomline experimental structure.
- [Benchmark](#usage): Comparison with other libraries.
- [Usage](#usage): List of commands.
- [Contributing](#contributing): Explanation of how you can join the project.
- [License](#license): Clarification of certain rules.

## Installation

Binary installers for the latest released version are available at the [Packagist
package index.](https://packagist.org/packages/maciejczyzewski/bottomline)

### Composer

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

### File

Put the require statement in your code:

```php
require 'bottomline/bottomline.php';
```

## Structure

Bottomline is based on namespaces and dynamic autoloader. The main file is `load.php` because it is responsible for loading the various functions from appropriate folders.

```bash
|-- src
|   |-- __
|   |   |-- arrays
|   |   |   |-- ...
|   |   |-- chaining
|   |   |   |-- ...
|   |   |-- collections
|   |   |   |-- ...
|   |   |-- functions
|   |   |   |-- ...
|   |   |-- objects
|   |   |   |-- ...
|   |   |-- utilities
|   |   |   |-- ...
|   |   |-- load.php
|-- tests
|   |-- arrays.php
|   |-- chaining.php
|   |-- collections.php
|   |-- functions.php
|   |-- objects.php
|   |-- utilities.php
|-- bottomline.php
|-- phpunit.xml
```

## Benchmarks

<div align="center">
  <img src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot-2.png"/>
</div>

## Usage

* Arrays
  - [__::append](src/__/arrays/append.php)

  ```php
  __::append([1, 2, 3], 4);
  // → [1, 2, 3, 4]
  ```

  - [__::compact](src/__/arrays/compact.php)

  Returns a copy of the array with falsy values removed.

  ```php
  __::compact([0, 1, false, 2, '', 3]);
  // → [1, 2, 3]
  ```

  - [__::flatten](src/__/arrays/flatten.php)

  Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.

  ```php
  __::flatten([1, 2, [3, [4]]]);
  // → [1, 2, 3, 4]
  ```

  - [__::patch](src/__/arrays/patch.php)

  Patches array with list of xpath-value pairs.

  ```php
  __::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
  // → ['addr' => ['country' => 'CA', 'zip' => 54321]]
  ```

  - [__::prepend](src/__/arrays/prepend.php)

  ```php
  __::prepend([1, 2, 3], 4);
  // → [4, 1, 2, 3]
  ```

  - [__::range](src/__/arrays/range.php)

  Returns an array of integers from start to stop (exclusive) by step.

  ```php
  __::range(1, 10, 2);
  // → [1, 3, 5, 7, 9]
  ```

  - [__::repeat](src/__/arrays/repeat.php)

  ```php
  __::repeat('foo', 3);
  // → ['foo', 'foo', 'foo']
  ```

* Chaining
  - [__::slug](src/__/chaining/slug.php)

  ```php
  __::slug('Jakieś zdanie z dużą ilością obcych znaków!');
  // → 'jakies-zdanie-z-duza-iloscia-obcych-znakow'
  ```

  - [__::truncate](src/__/chaining/truncate.php)

  ```php
  __::truncate('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.');
  // → 'Lorem ipsum dolor sit amet, ...'
  ```

  - [__::urlify](src/__/chaining/urlify.php)

  ```php
  __::urlify('I love https://google.com');
  // → 'I love <a href="https://google.com">google.com</a>'
  ```

* Collections
  - [__::filter](src/__/collections/filter.php)

  Return the values in the collection that pass the truth test.

  ```php
  $a = [
      ['name' => 'fred',   'age' => 32],
      ['name' => 'maciej', 'age' => 16]
  ];

  __::filter($a, function($n) {
      return $n['age'] > 24;
  });
  // → [['name' => 'fred', 'age' => 32]]
  ```

  - [__::first](src/__/collections/first.php)

  Get the first element of an array. Passing n returns the first n elements.

  ```php
  __::first([1, 2, 3, 4, 5], 2);
  // → [1, 2]
  ```

  - [__::get](src/__/collections/get.php)

  ```php
  __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
  // → 'ter'
  ```

  - [__::last](src/__/collections/last.php)

  Get the last element of an array. Passing n returns the last n elements.

  ```php
  __::last([1, 2, 3, 4, 5], 2);
  // → [4, 5]
  ```

  - [__::map](src/__/collections/map.php)

  Returns an array of values by mapping each in collection through the iterator.

  ```php
  __::map([1, 2, 3], function($n) {
      return $n * 3;
  });
  // → [3, 6, 9]
  ```

  - [__::max](src/__/collections/max.php)

  Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.

  ```php
  __::max([1, 2, 3]);
  // → 3
  ```

  - [__::min](src/__/collections/min.php)

  Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.

  ```php
  __::min([1, 2, 3]);
  // → 1
  ```

  - [__::pluck](src/__/collections/pluck.php)

  Extract an array of property values.

  ```php
  $a = [
      ['foo' => 'bar',  'bis' => 'ter' ],
      ['foo' => 'bar2', 'bis' => 'ter2'],
  ];

  __::pluck($a, 'foo');
  // → ['bar', 'bar2']
  ```

  - [__::where](src/__/collections/where.php)

  ```php
  $a = [
      ['name' => 'fred',   'age' => 32],
      ['name' => 'maciej', 'age' => 16]
  ];

  __::where($a, ['age' => 16]);
  // → [['name' => 'maciej', 'age' => 16]]
  ```

* Functions
* Objects
  - [__::isArray](src/__/objects/isArray.php)

  ```php
  __::isArray([1, 2, 3]);
  // → true
  ```

  - [__::isEmail](src/__/objects/isEmail.php)

  ```php
  __::isEmail('test@test.com');
  // → true
  ```

  - [__::isFunction](src/__/objects/isFunction.php)

  ```php
  __::isFunction(function ($a) { return $a + 2; });
  // → true
  ```

  - [__::isNull](src/__/objects/isNull.php)

  ```php
  __::isNull(null);
  // → true
  ```

  - [__::isNumber](src/__/objects/isNumber.php)

  ```php
  __::isNumber(123);
  // → true
  ```

  - [__::isObject](src/__/objects/isObject.php)

  ```php
  __::isObject('fred');
  // → false
  ```

  - [__::isString](src/__/objects/isString.php)

  ```php
  __::isString('fred');
  // → true
  ```

* Utilities

## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:

## License

See LICENSE file in this repository.
