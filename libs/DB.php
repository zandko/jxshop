<?php

namespace libs;

use PDO;
use PDOException;

class DB
{
    private $_pdo;
    private static $_instance;
    private $_error;
    private function __clone()
    {}
    private function __construct()
    {
        try {
            $this->_pdo = new PDO("mysql:host=127.0.0.1;dbname=jxshop", 'root', '123456');
            $this->_pdo->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            $this->_error = $e->getMessage();
            die($this->_error);
        }

    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function prepare($sql)
    {
        return $this->_pdo->prepare($sql);
    }

    public function exec($sql)
    {
        return $this->_pdo->exec($sql);
    }
}
