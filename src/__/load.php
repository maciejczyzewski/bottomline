<?php

namespace __;

/*                                                 *\
 *                   bottomline                    *
 *                                                 *
 ___________________________________________________
 ***************************************************

 ** Arrays                                       [6]
 ** Chaining                                     [3]
 ** Collections                                  [9]
 ** Functions                                    [0]
 ** Objects                                      [7]
 ** Utilities                                    [0]

 ***************************************************
 * bottomline v0.0.5                               *
 * bottomline is licensed under the MIT license    *
 * Copyright (c) 2014 Maciej A. Czyzewski          *
\***************************************************/

if (version_compare(PHP_VERSION, '5.4.0', '=<')) {
    throw new Exception('Your PHP installation is too old. Bottomline requires at least PHP 5.4.0', 1);
}

/** 'Given enough eyeballs, all bugs are shallow' -- Eric Raymond */
class __
{
    static $modules = array(
        'arrays',
        'chaining',
        'collections',
        'functions',
        'objects',
        'utilities'
    );

    static $functions = array();

    static public function __loader($name, $arguments)
    {
        if(empty(self::$functions))
        {
            foreach(self::$modules as $key => $value)
            {
                foreach(glob(__DIR__ .'/'. $value .'/*.php', GLOB_BRACE) as $function)
                {
                    $path = explode('.', str_replace(__DIR__ .'/', '', $function));
                    $alias = str_replace('/', '\\', array_shift($path));

                    if(!function_exists($alias))
                    {
                        self::$functions[] = $alias;
                        require $function;
                    }
                }
            }
        }

        foreach(self::$functions as $key => $value)
        {
            if(strpos($value, $name))
            {
                return call_user_func_array($value, $arguments);
            }
        }
    }

    public function __call($name, $arguments)
    {
        return self::__loader($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::__loader($name, $arguments);
    }
}