<?php
class Database
{
    // private static $dbName = 'id14974201_iotproject1';
    // private static $dbHost = 'localhost';
    // private static $dbUsername = 'id14974201_ultrasonic';
    // private static $dbUserPassword = '~T#f@9ukO>7g8a_l';

    private static $dbName = 'heroku_25074421fa4c861';
    private static $dbHost = 'us-cdbr-east-02.cleardb.com';
    private static $dbUsername = '1114bc27';
    private static $dbUserPassword = '~T#f@9ukO>7g8a_l';

    private static $cont  = null;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$cont) {
            try {
                self::$cont =  new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
