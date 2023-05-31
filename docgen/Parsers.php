<?php

namespace __\DocGen;

use Parsedown;
use phpDocumentor\Reflection\DocBlockFactory;
use PhpParser\Parser;
use PhpParser\ParserFactory;

abstract class Parsers
{
    public static DocBlockFactory $docBlockParser;

    public static Parser $phpParser;

    public static Parsedown $markdown;

    public static function setup()
    {
        if (!isset(self::$docBlockParser)) {
            self::$docBlockParser = DocBlockFactory::createInstance();
        }
        if (!isset(self::$phpParser)) {
            self::$phpParser = (new ParserFactory())->create(ParserFactory::PREFER_PHP5);
        }
        if (!isset(self::$markdown)) {
            self::$markdown = new Parsedown();
        }
    }
}
