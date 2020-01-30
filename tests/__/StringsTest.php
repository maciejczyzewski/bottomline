<?php

namespace __\Test;

use __;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function testCamelCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = '--foo-bar--';
        $c = '__FOO_BAR__';

        // Act
        $x = __::camelCase($a);
        $y = __::camelCase($b);
        $z = __::camelCase($c);

        // Assert
        $this->assertEquals('fooBar', $x);
        $this->assertEquals('fooBar', $y);
        $this->assertEquals('fooBar', $z);
    }

    public function testCapitalize()
    {
        // Arrange
        $a = 'FRED';

        // Act
        $x = __::capitalize($a);

        // Assert
        $this->assertEquals('Fred', $x);
    }

    public function testKebabCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::kebabCase($a);
        $y = __::kebabCase($b);
        $z = __::kebabCase($c);

        // Assert
        $this->assertEquals('foo-bar', $x);
        $this->assertEquals('foo-bar', $y);
        $this->assertEquals('foo-bar', $z);
    }

    public function testLowerCase()
    {
        // Arrange
        $a = '--Foo-Bar--';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::lowerCase($a);
        $y = __::lowerCase($b);
        $z = __::lowerCase($c);

        // Assert
        $this->assertEquals('foo bar', $x);
        $this->assertEquals('foo bar', $y);
        $this->assertEquals('foo bar', $z);
    }

    public function testLowerFirst()
    {
        // Arrange
        $a = 'Fred';
        $b = 'FRED';

        // Act
        $x = __::lowerFirst($a);
        $y = __::lowerFirst($b);

        // Assert
        $this->assertEquals('fred', $x);
        $this->assertEquals('fRED', $y);
    }

    public function testSnakeCase()
    {
        // Arrange
        $a = 'Foo Bar';
        $b = 'fooBar';
        $c = '--FOO-BAR--';

        // Act
        $x = __::snakeCase($a);
        $y = __::snakeCase($b);
        $z = __::snakeCase($c);

        // Assert
        $this->assertEquals('foo_bar', $x);
        $this->assertEquals('foo_bar', $y);
        $this->assertEquals('foo_bar', $z);
    }

    public function testSplit()
    {
        // Arrange
        $a = 'github.com';
        $b = 'a-b-c';

        // Act
        $x = __::split($a, '.');
        $y = __::split($b, '-');
        $z = __::split($b, '-', 2);

        // Assert
        $this->assertEquals(['github', 'com'], $x);
        $this->assertEquals(['a', 'b', 'c'], $y);
        $this->assertEquals(['a', 'b-c'], $z);
    }

    public function testStartCase()
    {
        // Arrange
        $a = '--foo-bar--';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::startCase($a);
        $y = __::startCase($b);
        $z = __::startCase($c);

        // Assert
        $this->assertEquals('Foo Bar', $x);
        $this->assertEquals('Foo Bar', $y);
        $this->assertEquals('FOO BAR', $z);
    }

    public function testToLower()
    {
        // Arrange
        $a = '--Foo-Bar--';
        $b = 'fooBar';
        $c = '__FOO_BAR__';

        // Act
        $x = __::toLower($a);
        $y = __::toLower($b);
        $z = __::toLower($c);

        // Assert
        $this->assertEquals('--foo-bar--', $x);
        $this->assertEquals('foobar', $y);
        $this->assertEquals('__foo_bar__', $z);
    }

    public function testToUpper()
    {
        // Arrange
        $a = '--foo-bar--';
        $b = 'fooBar';
        $c = '__foo_bar__';

        // Act
        $x = __::toUpper($a);
        $y = __::toUpper($b);
        $z = __::toUpper($c);

        // Assert
        $this->assertEquals('--FOO-BAR--', $x);
        $this->assertEquals('FOOBAR', $y);
        $this->assertEquals('__FOO_BAR__', $z);
    }

    public function testUpperCase()
    {
        // Arrange
        $a = '--foo-bar';
        $b = 'fooBar';
        $c = '__foo_bar__';

        // Act
        $x = __::upperCase($a);
        $y = __::upperCase($b);
        $z = __::upperCase($c);

        // Assert
        $this->assertEquals('FOO BAR', $x);
        $this->assertEquals('FOO BAR', $y);
        $this->assertEquals('FOO BAR', $z);
    }

    public function testUpperFirst()
    {
        // Arrange
        $a = 'fred';
        $b = 'FRED';

        // Act
        $x = __::upperFirst($a);
        $y = __::upperFirst($b);

        // Assert
        $this->assertEquals('Fred', $x);
        $this->assertEquals('FRED', $y);
    }

    public function testWords()
    {
        // Arrange
        $a = 'fred, barney, & pebbles';
        $b = 'fred, barney, & pebbles';
        $bPattern = '/[^, ]+/';
        $c = '';
        $d = 'fooBar';

        // Act
        $x = __::words($a);
        $y = __::words($b, $bPattern);
        $z = __::words($c);
        $u = __::words($d);

        // Assert
        $this->assertEquals(['fred', 'barney', 'pebbles'], $x);
        $this->assertEquals(['fred', 'barney', '&', 'pebbles'], $y);
        $this->assertEquals([], $z);
        $this->assertEquals(['foo', 'Bar'], $u);
    }
}
