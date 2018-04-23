<?php

namespace app\components;

/**
 * Singleton Pattern
 * Set connection with database
 */
class DbConnection
{
    private static $instance = null;

    /**
     * @var \PDO
     */
    private $pdo;

    private function __construct()
    {
        //setting get from config/db.php
        $db = Config::get('db');
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']}";
        $user = $db['username'];
        $pass = $db['password'];

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('SET NAMES utf8');
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DbConnection();
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}

