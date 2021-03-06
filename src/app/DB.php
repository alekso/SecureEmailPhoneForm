<?php
namespace app;
/**
 * Class DB
 * Creates Mysql PDO connection
 * @uses constant \DSN
 * @uses constant \USERNAME
 * @uses constant \PASSWORD
 * Look into config.php for configuration settings
 * @package app
 */
class DB
{
    private static $options=array(\PDO::ATTR_PERSISTENT=>true);

    public static function connect(array $config)
    {
        try
        {
           $_pdo = new \PDO (
               "mysql:dbname={$config['dbname']};host={$config['host']};port={$config['port']}",
               $config['username'],
               $config['password'],
               self::$options
           );

           $_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return  $_pdo;
        }
        catch (\PDOException $ex)
        {
            error_log("A database error occurred".$ex->getMessage(), 0);
            exit();
        }
    }
}