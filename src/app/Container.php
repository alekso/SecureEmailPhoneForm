<?php
namespace app;

class Container
{
    protected static $container=[];

    public static function bind($key, Callable $callback)
    {
        static::$container[$key]=$callback;
    }

    public static function make($name)
    {
        if (isset(static::$container[$name]))
        {
            $callback=static::$container[$name];

            if (is_callable($callback))

                return $callback();

            return $callback;
        }

        throw new \Exception('Binding does not exist in container');
    }
}

