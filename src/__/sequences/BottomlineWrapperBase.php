<?php

// Do NOT modify this file! This file is automatically generated.

/**
 * An abstract base class for documenting our sequence support
 *
 * @internal
 * @method static \BottomlineWrapper append(mixed $value = null) <p>Append an item to array.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::append([1, 2, 3], 4);</code></pre> <p><strong>Result</strong></p> <pre><code>[1, 2, 3, 4]</code></pre>
 * @method static \BottomlineWrapper chunk(int $size = 1, bool $preserveKeys = false) <p>Creates an array of elements split into groups the length of <code>$size</code>.</p><br><p>If array can't be split evenly, the final chunk will be the remaining elements. When <code>$preserveKeys</code> is set to TRUE, keys will be preserved. Default is FALSE, which will reindex the chunk numerically.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::chunk([1, 2, 3, 4, 5], 3);</code></pre> <p><strong>Result</strong></p> <pre><code>[[1, 2, 3], [4, 5]]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable objects are now supported</p></li></ul><h2>Exceptions</h2><ul><li><p><code>\InvalidArgumentException</code> - when an non-array or non-traversable object is given for $iterable.</p></li><li><p><code>\Exception</code> - when an <code>\IteratorAggregate</code> is given and <code>getIterator()</code> throws an exception.</p></li></ul><h2>Returns</h2><p>When given a <code>\Traversable</code> object for <code>$iterable</code>, a generator will be returned. Otherwise, an array will be returned.</p>
 * @method static \BottomlineWrapper compact() <p>Creates an array with all falsey values removed.</p><br><p>The following values are considered falsey:</p> <ul> <li><code>false</code></li> <li><code>null</code></li> <li><code>0</code></li> <li><code>""</code></li> <li><code>undefined</code></li> <li><code>NaN</code></li> </ul> <p><strong>Usage</strong></p> <pre><code class="language-php">__::compact([0, 1, false, 2, '', 3]);</code></pre> <p><strong>Result</strong></p> <pre><code>[1, 2, 3]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable objects are now supported</p></li></ul>
 * @method static \BottomlineWrapper drop(int $number = 1) <p>Creates a slice of array with n elements dropped from the beginning.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::drop([0, 1, 3, 5], 2);</code></pre> <p><strong>Result</strong></p> <pre><code>[3, 5]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable objects are now supported</p></li></ul>
 * @method static \BottomlineWrapper flatten(bool $shallow = false) <p>Flattens a multidimensional array or iterable.</p><br><p>If <code>$shallow</code> is set to TRUE, the array will only be flattened a single level.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::flatten([1, 2, [3, [4]]], false);</code></pre> <p><strong>Result</strong></p> <pre><code>[1, 2, 3, 4]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable objects are now supported</p></li></ul>
 * @method static \BottomlineWrapper patch(array $patches, string $parent = '') <p>Patches array by xpath.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::patch(<br />     [<br />         'addr' =&gt; [<br />             'country' =&gt; 'US',<br />             'zip' =&gt; 12345<br />         ]<br />     ],<br />     [<br />         '/addr/country' =&gt; 'CA',<br />         '/addr/zip' =&gt; 54321<br />     ]<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>['addr' =&gt; ['country' =&gt; 'CA', 'zip' =&gt; 54321]]</code></pre><h2>Returns</h2><p>Returns patched array</p>
 * @method static \BottomlineWrapper prepend(mixed $value = null) <p>Prepend item or value to an array.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::prepend([1, 2, 3], 4);</code></pre> <p><strong>Result</strong></p> <pre><code>[4, 1, 2, 3]</code></pre>
 * @method static \BottomlineWrapper randomize() <p>Shuffle an array ensuring no item remains in the same position.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::randomize([1, 2, 3]);</code></pre> <p><strong>Result</strong></p> <pre><code>[2, 3, 1]</code></pre>
 * @method static \BottomlineWrapper range(int $stop = null, int $step = 1) <p>Generate range of values based on start, end, and step.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::range(1, 10, 2);</code></pre> <p><strong>Result</strong></p> <pre><code>[1, 3, 5, 7, 9]</code></pre><h2>Returns</h2><p>range of values</p>
 * @method static \BottomlineWrapper repeat(int $times) <p>Generate array of repeated values.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::repeat('foo', 3);</code></pre> <p><strong>Result</strong></p> <pre><code>['foo', 'foo', 'foo']</code></pre><h2>Returns</h2><p>Returns a new array of filled values.</p>
 * @method static \BottomlineWrapper assign() <p>Combines and merge collections provided with each others.</p><br><p>If the collections have common keys, then the last passed keys override the previous. If numerical indexes are passed, then last passed indexes override the previous.</p> <p>For a recursive merge, see <code>__::merge()</code>.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::assign(<br />     [<br />         'color' =&gt; [<br />             'favorite' =&gt; 'red',<br />             5<br />         ],<br />         3<br />     ],<br />     [<br />         10,<br />         'color' =&gt; [<br />             'favorite' =&gt; 'green',<br />             'blue'<br />         ]<br />     ]<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     'color' =&gt; ['favorite' =&gt; 'green', 'blue'],<br />     10<br /> ]</code></pre><h2>Returns</h2><p>Assigned collection.</p>
 * @method static \BottomlineWrapper concat(iterable|\stdClass $_) <p>Combines and concat collections provided with each others.</p><br><p>If the collections have common keys, then the values are appended in an array. If numerical indexes are passed, then values are appended.</p> <p>For a recursive merge, see <code>__::merge()</code>.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::concat(<br />     ['color' =&gt; ['favorite' =&gt; 'red', 5], 3],<br />     [10, 'color' =&gt; ['favorite' =&gt; 'green', 'blue']]<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     'color' =&gt; ['favorite' =&gt; ['green'], 5, 'blue'],<br />     3,<br />     10<br /> ]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Returns</h2><p>If the first argument given to this function is an <code>\stdClass</code>, an <code>\stdClass</code> will be returned. Otherwise, an array will be returned.</p>
 * @method static \BottomlineWrapper concatDeep(iterable|\stdClass $_) <p>Recursively combines and concat collections provided with each others.</p><br><p>If the collections have common keys, then the values are appended in an array. If numerical indexes are passed, then values are appended.</p> <p>For a non-recursive concat, see <code>__::concat()</code>.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::concatDeep(<br />     ['color' =&gt; ['favorite' =&gt; 'red', 5], 3],<br />     [10, 'color' =&gt; ['favorite' =&gt; 'green', 'blue']]<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     'color' =&gt; [<br />         'favorite' =&gt; ['red', 'green'],<br />         5,<br />         'blue'<br />     ],<br />     3,<br />     10<br /> ]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable support was added</p></li></ul><h2>Returns</h2><p>A concatenated collection. When the first argument given is an <code>\stdClass</code>, then resulting value will be an <code>\stdClass</code>. Otherwise, an array will always be returned.</p>
 * @method static \BottomlineWrapper ease(string $glue = '.') <p>Flattens a complex collection by mapping each ending leafs value to a key consisting of all previous indexes.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::ease([<br />     'foo' =&gt; ['bar' =&gt; 'ter'],<br />     'baz' =&gt; ['b', 'z']<br /> ]);</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     'foo.bar' =&gt; 'ter',<br />     'baz.0' =&gt; 'b',<br />     'baz.1' =&gt; 'z'<br /> ]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Returns</h2><p>flatten collection</p>
 * @method static \BottomlineWrapper every(\Closure $iteratee) <p>Checks if predicate returns truthy for all elements of collection.</p><br><p>Iteration is stopped once predicate returns falsey.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::every([1, 3, 4], function ($value, $key, $collection) {<br />     return is_int($v);<br /> });</code></pre> <p><strong>Result</strong></p> <pre><code>true</code></pre>
 * @method static \BottomlineWrapper filter(\Closure|null $closure = null) <p>Returns the values in the collection that pass the truth test.</p><br><p>When <code>$closure</code> is set to null, this function will automatically remove falsey values. When <code>$closure</code> is given, then values where the closure returns false will be removed.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">$a = [<br />     ['name' =&gt; 'fred',   'age' =&gt; 32],<br />     ['name' =&gt; 'maciej', 'age' =&gt; 16]<br /> ];<br /> <br /> __::filter($a, function($n) {<br />     return $n['age'] &gt; 24;<br /> });</code></pre> <p><strong>Result</strong></p> <pre><code>[['name' =&gt; 'fred', 'age' =&gt; 32]]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - iterable objects are now supported</p></li></ul><h2>Exceptions</h2><ul><li><p><code>\InvalidArgumentException</code> - when an non-array or non-traversable object is given for $iterable.</p></li></ul><h2>Returns</h2><p>When given a <code>\Traversable</code> object for <code>$iterable</code>, a generator will be returned. Otherwise, an array will be returned.</p>
 * @method static \BottomlineWrapper first(int|null $count = null) <p>Gets the first element of an array/iterable. Passing n returns the first n elements.</p><br><p>When <code>$count</code> is <code>null</code>, only the first element will be returned.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::first([1, 2, 3, 4, 5], 2);</code></pre> <p><strong>Result</strong></p> <pre><code>[1, 2]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper get(string $path, mixed $default = null) <p>Get item of an array or object by index, accepting path (nested index).</p><br><p>If <code>$collection</code> is an object that implements the ArrayAccess interface, this function will treat it as an array instead of accessing class properties.</p> <p>Use a period (<code>.</code>) in <code>$path</code> to go down a level in a multidimensional array.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::get(['foo' =&gt; ['bar' =&gt; 'ter']], 'foo.bar');</code></pre> <p><strong>Result</strong></p> <pre><code>'ter'</code></pre>
 * @method static \BottomlineWrapper getIterator() <p>Get an iterator from an object that supports iterators; including generators.</p><br><h2>Exceptions</h2><ul><li><p><code>\InvalidArgumentException</code> - when $input does not implement <code>\Iterator</code> or <code>\IteratorAggregate</code></p></li><li><p><code>\Exception</code> - when <code>\IteratorAggregate::getIterator()</code> throws an exception</p></li></ul>
 * @method static \BottomlineWrapper groupBy(int|float|string|\Closure $key) <p>Returns an associative array where the keys are values of $key.</p><br><p>Based on Chauncey McAskill's <a href="https://gist.github.com/mcaskill/baaee44487653e1afc0d">array_group_by()</a> function.</p> <h2>Group by Key</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">__::groupBy([<br />         ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'School bus'],<br />         ['state' =&gt; 'CA', 'city' =&gt; 'San Diego', 'object' =&gt; 'Light bulb'],<br />         ['state' =&gt; 'CA', 'city' =&gt; 'Mountain View', 'object' =&gt; 'Space pen'],<br />     ],<br />     'state'<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />   'IN' =&gt; [<br />      ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'School bus'],<br />   ],<br />   'CA' =&gt; [<br />      ['state' =&gt; 'CA', 'city' =&gt; 'San Diego', 'object' =&gt; 'Light bulb'],<br />      ['state' =&gt; 'CA', 'city' =&gt; 'Mountain View', 'object' =&gt; 'Space pen'],<br />   ]<br /> ]</code></pre> <h2>Group by nested key (dot notation)</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">__::groupBy([<br />         ['object' =&gt; 'School bus', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis']],<br />         ['object' =&gt; 'Manhole', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis']],<br />         ['object' =&gt; 'Basketball', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Plainfield']],<br />         ['object' =&gt; 'Light bulb', 'metadata' =&gt; ['state' =&gt; 'CA', 'city' =&gt; 'San Diego']],<br />         ['object' =&gt; 'Space pen', 'metadata' =&gt; ['state' =&gt; 'CA', 'city' =&gt; 'Mountain View']],<br />     ],<br />     'metadata.state'<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />   'IN' =&gt; [<br />     'Indianapolis' =&gt; [<br />       ['object' =&gt; 'School bus', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis']],<br />       ['object' =&gt; 'Manhole', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis']],<br />     ],<br />     'Plainfield' =&gt; [<br />       ['object' =&gt; 'Basketball', 'metadata' =&gt; ['state' =&gt; 'IN', 'city' =&gt; 'Plainfield']],<br />     ],<br />   ],<br />   'CA' =&gt; [<br />     'San Diego' =&gt; [<br />       ['object' =&gt; 'Light bulb', 'metadata' =&gt; ['state' =&gt; 'CA', 'city' =&gt; 'San Diego']],<br />     ],<br />     'Mountain View' =&gt; [<br />       ['object' =&gt; 'Space pen', 'metadata' =&gt; ['state' =&gt; 'CA', 'city' =&gt; 'Mountain View']],<br />     ],<br />   ],<br /> ]</code></pre> <h2>Group by Closure</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">__::groupBy([<br />         (object)['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'School bus'],<br />         (object)['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'Manhole'],<br />         (object)['state' =&gt; 'CA', 'city' =&gt; 'San Diego', 'object' =&gt; 'Light bulb'],<br />     ],<br />     function ($value) {<br />         return $value-&gt;city;<br />     }<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />   'Indianapolis' =&gt; [<br />      ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'School bus'],<br />      ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'Manhole'],<br />   ],<br />   'San Diego' =&gt; [<br />      ['state' =&gt; 'CA', 'city' =&gt; 'San Diego', 'object' =&gt; 'Light bulb'],<br />   ]<br /> ]</code></pre>
 * @method static \BottomlineWrapper has(string|int $path) <p>Return true if <code>$collection</code> contains the requested <code>$key</code>.</p><br><p>In contrast to <code>isset()</code>, <code>__::has()</code> returns true if the key exists but is null.</p> <h2>Arrays</h2> <p><strong>Usage</strong></p> <pre><code class="language-php"> __::has(['foo' =&gt; ['bar' =&gt; 'num'], 'foz' =&gt; 'baz'], 'foo.bar');</code></pre> <p><strong>Result</strong></p> <pre><code>true</code></pre> <h2>Objects</h2> <p><strong>Usage</strong></p> <pre><code class="language-php"> __::hasKeys((object) ['foo' =&gt; 'bar', 'foz' =&gt; 'baz'], 'bar');</code></pre> <p><strong>Result</strong></p> <pre><code>false</code></pre>
 * @method static \BottomlineWrapper hasKeys(array $keys = [], bool $strict = false) <p>Returns true if <code>$input</code> contains all requested $keys. If <code>$strict</code> is <code>true</code> it also checks if <code>$input</code> exclusively contains the given <code>$keys</code>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::hasKeys(['foo' =&gt; 'bar', 'foz' =&gt; 'baz'], ['foo', 'foz']);</code></pre> <p><strong>Result</strong></p> <pre><code>true</code></pre>
 * @method static \BottomlineWrapper isEmpty() <p>Check if value is an empty array or object.</p><br><p>We consider any non enumerable as empty.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::isEmpty([]);</code></pre> <p><strong>Result</strong></p> <pre><code>true</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper last(int|null $take = null) <p>Get last item(s) of an array.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::last([1, 2, 3, 4, 5], 2);</code></pre> <p><strong>Result</strong></p> <pre><code>[4, 5]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper map(\Closure $iteratee) <p>Returns an array of values by mapping each in collection through the iteratee.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::map([1, 2, 3], function($value, $key, $collection) {<br />     return $value * 3;<br /> });</code></pre> <p><strong>Result</strong></p> <pre><code>[3, 6, 9]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper mapKeys(\Closure|null $closure = null) <p>Transforms the keys in a collection by running each key through the iterator.</p><br><p>This function throws an <code>\Exception</code> when the closure doesn't return a valid key that can be used in a PHP array.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::mapKeys(['x' =&gt; 1], function($key, $value, $collection) {<br />     return "{$key}_{$value}";<br /> });</code></pre> <p><strong>Result</strong></p> <pre><code>['x_1' =&gt; 1]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Exceptions</h2><ul><li><p><code>\Exception</code> - when closure doesn't return a valid key that can be used in PHP array</p></li></ul>
 * @method static \BottomlineWrapper mapValues(\Closure|null $closure = null) <p>Transforms the values in a collection by running each value through the iterator.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::mapValues(['x' =&gt; 1], function($value, $key, $collection) {<br />     return "{$key}_{$value}";<br /> });</code></pre> <p><strong>Result</strong></p> <pre><code>['x' =&gt; 'x_1']</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper max() <p>Returns the maximum value from the collection.</p><br><p>If passed an iterator, max will return max value returned by the iterator.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::max([1, 2, 3]);</code></pre> <p><strong>Result</strong></p> <pre><code>3</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Returns</h2><p>maximum value</p>
 * @method static \BottomlineWrapper merge() <p>Recursively combines and merge collections provided with each others.</p><br><ul> <li>If the collections have common keys, then the last passed keys override the previous.</li> <li>If numerical indexes are passed, then last passed indexes override the previous.</li> </ul> <p>For a non-recursive merge, see <code>__::assign()</code>.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::merge(<br />     ['color' =&gt; ['favorite' =&gt; 'red', 'model' =&gt; 3, 5], 3],<br />     [10, 'color' =&gt; ['favorite' =&gt; 'green', 'blue']]<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>['color' =&gt; ['favorite' =&gt; 'green', 'model' =&gt; 3, 'blue'], 10]</code></pre><h2>Returns</h2><p>Concatenated collection.</p>
 * @method static \BottomlineWrapper min() <p>Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::min([1, 2, 3]);</code></pre> <p><strong>Result</strong></p> <pre><code>1</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper pick(array $paths = [], mixed $default = null) <p>Returns an array having only keys present in the given path list.</p><br><p>Values for missing keys values will be filled with provided default value.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::pick(<br />     [<br />         'a' =&gt; 1,<br />         'b' =&gt; ['c' =&gt; 3, 'd' =&gt; 4]<br />     ],<br />     ['a', 'b.d']<br /> );</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     'a' =&gt; 1,<br />     'b' =&gt; ['d' =&gt; 4]<br /> ]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper pluck(string $property) <p>Returns an array of values belonging to a given property of each item in a collection.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">$a = [<br />     ['foo' =&gt; 'bar',  'bis' =&gt; 'ter' ],<br />     ['foo' =&gt; 'bar2', 'bis' =&gt; 'ter2'],<br /> ];<br /> <br /> __::pluck($a, 'foo');</code></pre> <p><strong>Result</strong></p> <pre><code>['bar', 'bar2']</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper reduce(\Closure $iteratee, array|\stdClass|mixed $accumulator = null) <p>Reduces <code>$collection</code> to a value which is the $accumulator result of running each element in <code>$collection</code> thru <code>$iteratee</code>, where each successive invocation is supplied the return value of the previous.</p><br><p>If <code>$accumulator</code> is not given, the first element of <code>$collection</code> is used as the initial value.</p> <h2>Sum Example</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">__::reduce([1, 2], function ($accumulator, $value, $key, $collection) {<br />     return $accumulator + $value;<br /> }, 0);</code></pre> <p><strong>Result</strong></p> <pre><code>3</code></pre> <h2>Array Counter</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">$a = [<br />     ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'School bus'],<br />     ['state' =&gt; 'IN', 'city' =&gt; 'Indianapolis', 'object' =&gt; 'Manhole'],<br />     ['state' =&gt; 'IN', 'city' =&gt; 'Plainfield', 'object' =&gt; 'Basketball'],<br />     ['state' =&gt; 'CA', 'city' =&gt; 'San Diego', 'object' =&gt; 'Light bulb'],<br />     ['state' =&gt; 'CA', 'city' =&gt; 'Mountain View', 'object' =&gt; 'Space pen'],<br /> ];<br /> <br /> $iteratee = function ($accumulator, $value) {<br />     if (isset($accumulator[$value['city']]))<br />         $accumulator[$value['city']]++;<br />     else<br />         $accumulator[$value['city']] = 1;<br />     return $accumulator;<br /> };<br /> <br /> __::reduce($c, $iteratee, []);</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />    'Indianapolis' =&gt; 2,<br />    'Plainfield' =&gt; 1,<br />    'San Diego' =&gt; 1,<br />    'Mountain View' =&gt; 1,<br /> ]</code></pre> <h2>Object Usage</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">$object = new \stdClass();<br /> $object-&gt;a = 1;<br /> $object-&gt;b = 2;<br /> $object-&gt;c = 1;<br /> <br /> __::reduce($object, function ($result, $value, $key) {<br />     if (!isset($result[$value]))<br />         $result[$value] = [];<br /> <br />     $result[$value][] = $key;<br /> <br />     return $result;<br /> }, [])</code></pre> <p><strong>Result</strong></p> <pre><code>[<br />     '1' =&gt; ['a', 'c'],<br />     '2' =&gt; ['b']<br /> ]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Returns</h2><p>Returns the accumulated value.</p>
 * @method static \BottomlineWrapper reduceRight(\Closure $iteratee, array|\stdClass|mixed $accumulator = null) <p>Reduces <code>$collection</code> to a value which is the <code>$accumulator</code> result of running each element in <code>$collection</code> - from right to left - thru <code>$iteratee</code>, where each successive invocation is supplied the return value of the previous.</p><br><p>If <code>$accumulator</code> is not given, the first element of $collection is used as the initial value.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::reduceRight(['a', 'b', 'c'], function ($accumulator, $value, $key, $collection) {<br />     return $accumulator . $value;<br /> }, '');</code></pre> <p><strong>Result</strong></p> <pre><code>'cba'</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul><h2>Returns</h2><p>Returns the accumulated value.</p>
 * @method static \BottomlineWrapper reverseIterable() <p>Return the reverse of an array or other foreach-able (Iterable).</p><br><p>For array it does not make a copy of it; but does make a copy to memory for other traversables.</p> <p>Code (using <code>yield</code>) is from mpen and linepogl See <a href="https://stackoverflow.com/a/36605605/1956471">https://stackoverflow.com/a/36605605/1956471</a></p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::reverseIterable([1, 2, 3]);</code></pre> <p><strong>Result</strong></p> <pre><code>Generator([3, 2, 1])</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper set(string $path, mixed $value = null) <p>Return a new collection with the item set at index to given value. Index can be a path of nested indexes.</p><br><ul> <li>If <code>$collection</code> is an object that implements the ArrayAccess interface, this function will treat it as an array.</li> <li>If a portion of path doesn't exist, it's created. Arrays are created for missing index in an array; objects are created for missing property in an object.</li> </ul> <p>This function throws an <code>\Exception</code> if the path consists of a non-collection.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::set(['foo' =&gt; ['bar' =&gt; 'ter']], 'foo.baz.ber', 'fer');</code></pre> <p><strong>Result</strong></p> <pre><code>['foo' =&gt; ['bar' =&gt; 'ter', 'baz' =&gt; ['ber' =&gt; 'fer']]]</code></pre><h2>Exceptions</h2><ul><li><p><code>\Exception</code> - if the path consists of a non collection</p></li></ul><h2>Returns</h2><p>the new collection with the item set</p>
 * @method static \BottomlineWrapper size() <p>Get the size of an array or \Countable object. Or get the number of properties an object has.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::size(null)                    // false<br /> __::size("true")                  // false; a string is not a collection<br /> __::size([1, 2, 3])               // 3<br /> __::size((object)[1, 2])          // 2<br /> __::size(new ArrayIterator(5, 4)) // 2</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - </p></li></ul><h2>Returns</h2><p>False when the given object does not support getting its size.</p>
 * @method static \BottomlineWrapper unease(string $separator = '.') <p>Builds a multidimensional collection out of a hash map using the key as indicator where to put the value.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::unease(['foo.bar' =&gt; 'ter', 'baz.0' =&gt; 'b', , 'baz.1' =&gt; 'z']);</code></pre> <p><strong>Result</strong></p> <pre><code>['foo' =&gt; ['bar' =&gt; 'ter'], 'baz' =&gt; ['b', 'z']]</code></pre><h2>Changelog</h2><ul><li><p><code>0.2.0</code> - added support for iterables</p></li></ul>
 * @method static \BottomlineWrapper where(array $cond = []) <p>Return data matching specific key value condition.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">$a = [<br />     ['name' =&gt; 'fred',   'age' =&gt; 32],<br />     ['name' =&gt; 'maciej', 'age' =&gt; 16]<br /> ];<br /> <br /> __::where($a, ['age' =&gt; 16]);</code></pre> <p><strong>Result</strong></p> <pre><code>[['name' =&gt; 'maciej', 'age' =&gt; 16]]</code></pre>
 * @method static \BottomlineWrapper slug(array $options = []) <p>Create a web friendly URL slug from a string.</p><br><p>Although supported, transliteration is discouraged because:</p> <ol> <li>most web browsers support UTF-8 characters in URLs</li> <li>transliteration causes a loss of information</li> </ol> <p><strong>Usage</strong></p> <pre><code class="language-php">__::slug('Jakieś zdanie z dużą ilością obcych znaków!');</code></pre> <p><strong>Result</strong></p> <pre><code>'jakies-zdanie-z-duza-iloscia-obcych-znakow'</code></pre>
 * @method static \BottomlineWrapper truncate(int $limit) <p>Truncate string based on count of words</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';<br /> <br /> __::truncate($string);</code></pre> <p><strong>Result</strong></p> <pre><code>'Lorem ipsum dolor sit amet, ...'</code></pre>
 * @method static \BottomlineWrapper urlify() <p>Convert any URLs into HTML anchor tags in a string.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::urlify("I love https://google.com");</code></pre> <p><strong>Result</strong></p> <pre><code>'I love &lt;a href="https://google.com"&gt;google.com&lt;/a&gt;'</code></pre>
 * @method static \BottomlineWrapper isArray() <p>Check if give value is array or not.</p>
 * @method static \BottomlineWrapper isCollection() <p>Check if the object is a collection.</p><br><p>A collection is either an array or an object.</p>
 * @method static \BottomlineWrapper isEmail() <p>Check if the value is valid email.</p>
 * @method static \BottomlineWrapper isEqual(mixed $object2) <p>Check if the objects are equals.</p><br><p>Perform a deep (recursive) comparison when the parameters are arrays or objects.</p> <p>Note: This method supports comparing arrays, object objects, booleans, numbers, strings. object objects are compared by their own enumerable properties (as returned by get_object_vars).</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::isEqual(['honfleur' =&gt; 1, 'rungis' =&gt; [2, 3]], ['honfleur' =&gt; 1, 'rungis' =&gt; [1, 2]]);</code></pre> <p><strong>Result</strong></p> <pre><code>false</code></pre>
 * @method static \BottomlineWrapper isFunction() <p>Check if give value is function or not.</p>
 * @method static \BottomlineWrapper isIterable(bool $strict = true) <p>Check to see if something is iterable.</p>
 * @method static \BottomlineWrapper isNull() <p>Check if give value is null or not.</p>
 * @method static \BottomlineWrapper isNumber() <p>Check if give value is number or not.</p>
 * @method static \BottomlineWrapper isObject() <p>Check if give value is object or not.</p>
 * @method static \BottomlineWrapper isString() <p>Check if give value is string or not.</p>
 * @method static \BottomlineWrapper chain() <p>Returns a wrapper instance, allows the value to be passed through multiple bottomline functions.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::chain([0, 1, 2, 3, null])<br />     -&gt;compact()<br />     -&gt;prepend(4)<br />     -&gt;value()<br /> ;</code></pre> <p><strong>Result</strong></p> <pre><code>[4, 1, 2, 3]</code></pre>
 * @method static \BottomlineWrapper camelCase() <p>Converts string to <a href="https://en.wikipedia.org/wiki/CamelCase">camel case</a>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::camelCase('Foo Bar');</code></pre> <p><strong>Result</strong></p> <pre><code>'fooBar'</code></pre>
 * @method static \BottomlineWrapper capitalize() <p>Converts the first character of string to upper case and the remaining to lower case.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::capitalize('FRED');</code></pre> <p><strong>Result</strong></p> <pre><code>'Fred'</code></pre>
 * @method static \BottomlineWrapper kebabCase() <p>Converts string to <a href="https://en.wikipedia.org/wiki/Letter_case#Special_case_styles">kebab case</a>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::kebabCase('Foo Bar');</code></pre> <p><strong>Result</strong></p> <pre><code>'foo-bar'</code></pre>
 * @method static \BottomlineWrapper lowerCase() <p>Converts string, as space separated words, to lower case.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::lowerCase('--Foo-Bar--');</code></pre> <p><strong>Result</strong></p> <pre><code>'foo bar'</code></pre>
 * @method static \BottomlineWrapper lowerFirst() <p>Converts the first character of string to lower case, like lcfirst.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::lowerFirst('Fred');</code></pre> <p><strong>Result</strong></p> <pre><code>'fred'</code></pre>
 * @method static \BottomlineWrapper snakeCase() <p>Converts string to <a href="https://en.wikipedia.org/wiki/Snake_case">snake case</a>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::snakeCase('Foo Bar');</code></pre> <p><strong>Result</strong></p> <pre><code>'foo_bar'</code></pre>
 * @method static \BottomlineWrapper split(string $delimiter, int $limit = 9223372036854775807) <p>Split a string by string.</p><br><ul> <li>If limit is set and positive, the returned array will contain a maximum of limit elements with the last element containing the rest of string.</li> <li>If the limit parameter is negative, all components except the last <code>-limit</code> are returned.</li> <li>If the limit parameter is zero, then this is treated as 1.</li> </ul> <p><strong>Usage</strong></p> <pre><code class="language-php">__::split('a-b-c', '-', 2);</code></pre> <p><strong>Result</strong></p> <pre><code>['a', 'b-c']</code></pre>
 * @method static \BottomlineWrapper startCase() <p>Converts string to <a href="https://en.wikipedia.org/wiki/Letter_case#Stylistic_or_specialised_usage">start case</a>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::startCase('--foo-bar--');</code></pre> <p><strong>Result</strong></p> <pre><code>'Foo Bar'</code></pre>
 * @method static \BottomlineWrapper toLower() <p>Converts string, as a whole, to lower case just like <code>strtolower()</code>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::toLower('fooBar');</code></pre> <p><strong>Result</strong></p> <pre><code>'foobar'</code></pre>
 * @method static \BottomlineWrapper toUpper() <p>Converts string, as a whole, to lower case just like <code>strtoupper()</code>.</p><br><p><strong>Usage</strong></p> <pre><code>__::toUpper('fooBar');</code></pre> <p><strong>Result</strong></p> <pre><code>'FOOBAR'</code></pre>
 * @method static \BottomlineWrapper upperCase() <p>Converts string, as space separated words, to upper case.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::upperCase('--foo-bar');</code></pre> <p><strong>Result</strong></p> <pre><code>'FOO BAR'</code></pre>
 * @method static \BottomlineWrapper upperFirst() <p>Converts the first character of string to upper case, like <code>ucfirst()</code>.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::upperFirst('fred');</code></pre> <p><strong>Result</strong></p> <pre><code>'Fred'</code></pre>
 * @method static \BottomlineWrapper words(string|null $pattern = null) <p>Splits string into an array of its words.</p><br><h2>Default Behavior</h2> <p><strong>Usage</strong></p> <pre><code class="language-php">__::words('fred, barney, &amp; pebbles');</code></pre> <p><strong>Result</strong></p> <pre><code>['fred', 'barney', 'pebbles']</code></pre> <h2>Custom Pattern</h2> <p>Use a custom regex to define how words are split.</p> <p><strong>Usage</strong></p> <pre><code class="language-php">__::words('fred, barney, &amp; pebbles', '/[^, ]+/');</code></pre> <p><strong>Result</strong></p> <pre><code>['fred', 'barney', '&amp;', 'pebbles']</code></pre>
 * @method static \BottomlineWrapper identity() <p>Returns the first argument it receives.</p><br><p><strong>Usage</strong></p> <pre><code class="language-php">__::identity('arg1', 'arg2');</code></pre> <p><strong>Result</strong></p> <pre><code>'arg1'</code></pre>
 * @method static \BottomlineWrapper now() <p>Alias to original time() function which returns current time.</p>
 */
abstract class BottomLineWrapperBase
{
}