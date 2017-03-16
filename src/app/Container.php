<?php
namespace app;

class Container
{
    protected static $container=[];

    public static function bind($key, Callable $callback)
    {
        static::$container[$key]=$callback;
    }

    public static function make($name, $arg)
    {
        if (isset(static::$container[$name]))
        {
            $callback=static::$container[$name];

            if (is_callable($callback))

                return $callback($arg);

            return $callback;
        }

        throw new \Exception('Binding does not exist in container');
    }
}

