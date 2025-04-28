<?php
namespace App\Config;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new \PDO(
            'mysql:host=localhost;dbname=chat_app;charset=utf8',
            'root',
            'root'
        );
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}