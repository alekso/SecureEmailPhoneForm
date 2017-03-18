<?php


namespace app;


class Config
{
    protected static $config=array();

    public static function load($filename)
    {
        self::$config = json_decode(file_get_contents($filename), true);
    }
    public static function get($key)
    {
        return self::$config[$key];
    }
}