# Changelog

## v0.2.0

**2020-04-22 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.1.2...0.2.0) — [Docs](https://maciejczyzewski.github.io/bottomline/)**

* Added `__::isEqual`
* Bumped minimum PHP version to 5.5
* The following functions now have iterable support. When given a `\Traversable` object, functions will return generators *if* the function does not need to exhaust the iterator; otherwise, it will return an array. ([#48](https://github.com/maciejczyzewski/bottomline/pull/48))
  - `__::chunk(): array|\Generator`
  - `__::compact(): array|\Generator`
  - `__::concat(): array`
  - `__::concatDeep(): array`
  - `__::doForEach(): void`
  - `__::doForEachRight(): void`
  - `__::drop(): array|\Generator`
  - `__::ease(): array`
  - `__::every(): void`
  - `__::filter(): array|\Generator`
  - `__::first(): mixed`
  - `__::flatten(): array|\Generator`
  - `__::groupBy(): array`
  - `__::isEmpty(): bool`
  - `__::last(): array`
  - `__::map(): array|\Generator`
  - `__::mapKeys(): array|\Generator`
  - `__::mapValues(): array|\Generator`
  - `__::max(): mixed`
  - `__::merge(): array`
  - `__::min(): mixed`
  - `__::pick(): array`
  - `__::pluck(): array`
  - `__::reduce(): array`
  - `__::reduceRight(): array`
  - `__::reverseIterable(): array|\Generator`
  - `__::size(): int`
  - `__::unease(): array`
  - `__::where(): array`
* Significantly improve type hint documentation for our sequences functionality via `chain()`

## v0.1.2

**Aug 15, 2018 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.1.1...0.1.2) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.1.2/README.md)**

* Added `__::assign`
* Added `__::concat`
* Added `__::concatDeep`
* Added `__::merge`
* Added `__::doForEachRight`
* Added `__::reduceRight`
* Added `__::isEqual`
* Added `__::reverseIterable`
* Made `__::get` and `__::set` work as array getter and setter for objects implementing the ArrayAccess interface
* Made `__::has` call `offsetExists()` for objects implementing the ArrayAccess interface
* Added dot notation support to `__::groupBy()`; it now uses `__::get()` and `__::set()` internally
* Rewrote documentation for each separate function
* Documentation in `load.php` is now generated from the individual function docs

## v0.1.1

**Jan 12, 2018 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.1.0...0.1.1) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.1.1/README.md)**

* Added `__::pick`
* Added `__::groupBy`
* Added `__::reduce`
* Added `__::mapKeys`
* Added `__::mapValues`
* Added `__::identity`
* Added `__::isCollection`
* Added `__::has`
* Added `__::split`
* Added `__::drop`
* Added `__::isEmpty`
* Added `__::doForEach`
* Added `__::every`
* Made `__::pick()`, `__::set()`, `__::map()` and `__::hasKeys()` to work on both arrays and objects
* Made `__::hasKeys()` to work with paths
* Made `__::set()` to return a copy of the collection (do not mutate)
* Removed `$strict` optional parameter of `__::set()`: it always create or override portion of path

## v0.1.0

**Sept 24, 2017 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.9...0.1.0) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.1.0/README.md)**

* Added `__::camelCase`
* Added `__::capitalize`
* Added `__::kebabCase`
* Added `__::lowerCase`
* Added `__::lowerFirst`
* Added `__::snakeCase`
* Added `__::startCase`
* Added `__::toLower`
* Added `__::toUpper`
* Added `__::upperCase`
* Added `__::upperFirst`
* Added `__::words`

## v0.0.9

**Jan 5, 2017 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.8...0.0.9) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.9/README.md)**

* Added benchmark `bench.php`
* PHPDoc and code normalization

## v0.0.8

**Jan 3, 2017 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.7...0.0.8) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.8/README.md)**

* Added `__::chunk`
* Added `__::randomize`
* Added `__::ease`
* Added `__::hasKeys`
* Added `__::set`
* Added `__::unease`
* Simplified “Array” methods
* Enhanced PHPDoc

## v0.0.7

**Dec 1, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.6...0.0.7) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.7/README.md)**

* Added `__::now`
* Documentation improvements

## v0.0.6

**Aug 7, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.5...0.0.6) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.6/README.md)**

* Added `__::patch`
* Added benchmark with other libraries
* Added Composer installation instructions
* Added PHPDoc on each function

## v0.0.5

**Jul 27, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/0.0.4...0.0.5) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.5/README.md)**

* Added `__::append`
* Added `__::flatten`
* Added `__::prepend`
* Added `__::slug`
* Added `__::truncate`
* Added `__::urlify`
* Added `__::first`
* Added `__::last`
* Added `__::get`
* Added `__::pluck`
* Added `__::where`
* Added `__::isArray`
* Added `__::isEmail`
* Added `__::isFunction`
* Added `__::isNull`
* Added `__::isNumber`
* Added `__::isObject`
* Added `__::isString`
* Added benchmark with other libraries
* Added Composer installation instructions
* Added PHPDoc on each function

## v0.0.4

**Jun 23, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/v0.0.3...0.0.4) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/0.0.4/README.md)**

* Added `__::compact`
* Added `__::range`
* Added `__::repeat`
* Added `__::filter`
* Added `__::map`
* Added `__::max`
* Added `__::min`
* Added internal function autoloader `__::load`
* Added unit tests (PHPUnit)

## v0.0.3

**Jan 17, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/v0.0.2...v0.0.3) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/v0.0.3/README.md)**

* Added `__::each`

## v0.0.2

**Jan 6, 2014 — [Diff](https://github.com/maciejczyzewski/bottomline/compare/v0.0.1...v0.0.2) — [Docs](https://github.com/maciejczyzewski/bottomline/blob/v0.0.2/README.md)**

* Added branding
* Written `README.md`

## v0.0.1

**Jan. 6, 2014 — [Docs](https://github.com/maciejczyzewski/bottomline/blob/v0.0.1/README.md)**

* Initial release
