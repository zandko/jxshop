<?php

namespace libs;

use PDO;
use PDOException;

class DB
{
    private static $_pdo;
    private static $_instance;
    private static $_error;
    private function __clone()
    {}
    private function __construct()
    {
        try {
            self::$pdo = new PDO("mysql:host=127.0.0.1;dbname=jxshop", 'root', '123456');
            self::$pdo->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            self::$_error = $e->getMessage();
            die(self::$_error);
        }

    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}
