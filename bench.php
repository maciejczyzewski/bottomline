<?php

require __DIR__ . '/bottomline.php';

$methods    = [
    // arrays
    'append', 'chunk', 'compact', 'flatten', 'patch', 'prepend', 'randomize', 'range', 'repeat',
    // collections
    'ease', 'filter', 'first', 'get', 'hasKeys', 'last', 'map', 'max', 'min', 'pluck', 'set', 'unease', 'where',
    // functions
    'slug', 'truncate', 'urlify'
];
$benchCount = 100000;

// read params
if (isset($argv[1]) && in_array($argv[1], $methods)) {
    $methods = [$argv[1]];
}
if (isset($argv[1]) && is_numeric($argv[1])) {
    $benchCount = (int)$argv[1];
} elseif (isset($argv[2])) {
    $benchCount = (int)$argv[2];
}

$totalStartTime = microtime(true);

echo 'Start ', $benchCount, ' executions', PHP_EOL;

foreach ($methods as $method) {
    $func      = 'bench_' . $method;
    $startTime = microtime(true);
    for ($i = 0; $i < $benchCount; $i++) {
        call_user_func_array($func, [$i]);
    }
    $endTime = microtime(true);
    echo $method, ': ', round($endTime - $startTime, 5), 'sec', PHP_EOL;
}

echo PHP_EOL, 'Total: ', round(microtime(true) - $totalStartTime, 5), 'sec', PHP_EOL;
echo 'Memory: ';
$size = memory_get_peak_usage(true);
$unit = ['b', 'kb', 'mb', 'gb'];
echo round($size / pow(1024, ($i = floor(log($size, 1024)))), 2), $unit[$i], PHP_EOL;

// Arrays:

function bench_append($i)
{
    __::append([1, 2, 3, 's' => $i], $i);
}

function bench_chunk($i)
{
    __::chunk([1, 2, 3, 4, 5, $i], 3);
}

function bench_compact($i)
{
    __::compact([0, 1, false, 2, '', 3, $i]);
}

function bench_flatten($i)
{
    __::flatten([1, 2, [3, [[4], $i]]]);
}

function bench_patch($i)
{
    // Arrange
    $a = [1, 1, 1, 'contacts' => ['country' => 'US', 'tel' => [$i]], 99];
    $p = ['/0' => 2, '/1' => 3, '/contacts/country' => 'CA', '/contacts/tel/0' => 3456];

    __::patch($a, $p);
}

function bench_prepend($i)
{
    __::prepend([1, 2, 3], $i);
}

function bench_randomize($i)
{
    __::randomize([1, 2, 3, 4, $i]);
}

function bench_range($i)
{
    __::range(1, 10, 2);
}

function bench_repeat($i)
{
    __::repeat('foo', 100);
}

// Collections:

function bench_ease($i)
{
    __::ease(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]);
}

function bench_filter($i)
{
    $a = [1, 2, 3, 4, 5, $i];
    __::filter($a, function ($n) {
        return $n > 3;
    });
}

function bench_first($i)
{
    __::first([1, 2, 3, 4, 5, $i], 2);
}

function bench_get($i)
{
    __::get(['foo' => ['bar' => $i]], 'foo.bar');
}

function bench_hasKeys($i)
{
    $a = ['foo' => 'bar', $i];
    __::hasKeys($a, ['foo', 'foz'], false);
    __::hasKeys($a, ['foo', 'foz'], true);
}

function bench_last($i)
{
    $a = [1, 2, 3, 4, 5, $i];
    __::last($a, 2);
    __::last($a);
}

function bench_map($i)
{
    __::map([1, 2, 3, $i], function ($n) {
        return $n * 3;
    });
}

function bench_max($i)
{
    __::max([1, 2, 3, $i]);
}


function bench_min($i)
{
    __::max([1, 2, 3, $i]);
}

function bench_pluck($i)
{
    __::pluck([
        ['foo' => 'bar', 'bis' => 'ter'],
        ['foo' => 'bar2', 'bis' => 'ter2', $i],
    ], 'foo');
}

function bench_set($i)
{
    __::set([['foo' => ['bar' => $i]]], 'foo.baz.ber', $i);
}

function bench_unease($i)
{
    __::unease(['foo.bar' => 'ter', 'baz.0' => $i, 'baz.1' => 'z']);
}

function bench_where($i)
{
    __::where([
        ['name' => 'fred', 'age' => 32],
        ['name' => 'maciej', 'age' => $i]
    ], ['age' => $i]);
}

function bench_slug($i)
{
    __::slug('Jakieś zdanie z dużą ilością obcych znaków!' . $i);
}

function bench_truncate($i)
{
    __::truncate('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.' . $i, 5);
}

function bench_urlify($i)
{
    __::urlify('I love https://google.com' . $i);
}
