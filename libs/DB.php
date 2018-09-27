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

    /**
     * 返回唯一的对象
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * 预处理执行sql
     */
    public function prepare($sql)
    {
        return $this->_pdo->prepare($sql);
    }

    /**
     * 非预处理执行sql
     */
    public function exec($sql)
    {
        return $this->_pdo->exec($sql);
    }

    /**
     * 获取最新添加记录的ID
     */
    public function lastInsertId()
    {
        return $this->_pdo->lastInsertId();
    }
}
