<div align="center">
  <img src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot.png"/>
</div>

# bottomline [![Build Status](https://travis-ci.org/MaciejCzyzewski/bottomline.png)](https://travis-ci.org/MaciejCzyzewski/bottomline) [![PHP version](https://badge.fury.io/ph/maciejczyzewski%2Fbottomline.svg)](http://badge.fury.io/ph/maciejczyzewski%2Fbottomline)

Useful feature pack.

## Introduction

It's a utility library delivering consistency, customization, performance & extras.

#### More reading:

- [Features](#features): List of functions.
- [Contributing](#contributing): Explanation of how you can join the project.
- [License](#license): Clarification of certain rules.

## Features

* Arrays
  - [__::append](src/__/arrays/append.php)

	```php
	__::append([1, 2, 3], 4);
	// → [1, 2, 3, 4]
	```

  - [__::compact](src/__/arrays/compact.php)

	```php
	__::compact([0, 1, false, 2, '', 3]);
	// → [1, 2, 3]
	```

  - [__::prepend](src/__/arrays/prepend.php)

	```php
	__::prepend([1, 2, 3], 4);
	// → [4, 1, 2, 3]
	```

  - [__::range](src/__/arrays/range.php)

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

* Collections
  - [__::filter](src/__/collections/filter.php)

	```php
	__::filter([1, 2, 3, 4, 5], function($n) {
	    return $n > 3;
	});
	// → [4, 5]
	```

  - [__::first](src/__/collections/first.php)

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

	```php
	__::last([1, 2, 3, 4, 5], 2);
	// → [4, 5]
	```

  - [__::map](src/__/collections/map.php)

	```php
	__::map([1, 2, 3], function($n) {
	    return $n * 3;
	});
	// → [3, 6, 9]
	```

  - [__::max](src/__/collections/max.php)

	```php
	__::max([1, 2, 3]);
	// → 3
	```

  - [__::min](src/__/collections/min.php)

	```php
	__::min([1, 2, 3]);
	// → 1
	```

  - [__::pluck](src/__/collections/pluck.php)

	```php
	$a = [
	    ['foo' => 'bar',  'bis' => 'ter' ],
	    ['foo' => 'bar2', 'bis' => 'ter2'],
	];

	__::pluck($a, 'foo');
	// → ['bar', 'bar2']
	```

* Objects 

* Utilities

## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:

[![Gitter chat](https://badges.gitter.im/MaciejCzyzewski/bottomline.png)](https://gitter.im/MaciejCzyzewski/bottomline)

## License

See LICENSE file in this repository.
