<div align="center">
  <img src="https://raw.githubusercontent.com/MaciejCzyzewski/bottomline/master/screenshot.png"/>
</div>

# bottomline [![Build Status](https://travis-ci.org/MaciejCzyzewski/bottomline.png)](https://travis-ci.org/MaciejCzyzewski/bottomline) [![PHP version](https://badge.fury.io/ph/maciejczyzewski%2Fbottomline.svg)](http://badge.fury.io/ph/maciejczyzewski%2Fbottomline)

Useful feature pack.

## Introduction

It's a utility library delivering consistency, customization, performance & extras.

## Features

* Arrays
  - [__::compact](src/__/arrays/compact.php)

	```php
	__::compact([0, 1, false, 2, '', 3]);
	// → [1, 2, 3]
	```

  - [__::get](src/__/arrays/get.php)

	```php
	__::get(['foo' => ['bar' => 'ter']], 'foo.bar');
	// → 'ter'
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
