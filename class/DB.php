<?php

/**
 * Class DB
 */
class DB
{
    static private $dbh;

    // 连接数据库
    private function __construct()
    {

    }

    private function __clone()
    {

    }

    private static function init()
    {

        $config = include_once APP_DIR . '/config/database.php';
        try {
            self::$dbh = new PDO("mysql:host={$config['host']};dbname=message", $config['username'], $config['password']);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * @return PDO
     */
    public static function instance()
    {
        if (empty(self::$dbh)) {
            self::init();
        }
        return self::$dbh;
    }
}

?>