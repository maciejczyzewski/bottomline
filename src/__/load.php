<?php

namespace __;

/*                                                 *\
 *                   bottomline                    *
 *                                                 *
 ___________________________________________________
 ***************************************************

 ** Arrays                                      [20]
 ** Chaining                                     [2]
 ** Collections                                 [26]
 ** Functions                                   [15]
 ** Objects                                     [39]
 ** Utilities                                   [17]

 *************************************************** 
 * bottomline v0.0.2                               *
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
        'function', 
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
                    require $function;
                    self::$functions[] = str_replace('/', '\\', array_shift(explode('.', 
                        str_replace(__DIR__ .'/', '', $function)))
                    );
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