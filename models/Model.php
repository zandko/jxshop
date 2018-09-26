<?php

namespace models;

use libs\DB;

class Model
{
    protected $_db;
    protected $tableName;
    protected $data;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function insert()
    {
        $keys = [];
        $values = [];
        $token = [];
        foreach ($this->data as $k => $v) {
            $keys[] = $k;
            $values[] = $v;
            $token[] = '?';
        }

        $keys = implode(',', $keys);
        $token = implode(',', $token);

        $sql = "INSERT INTO {$this->tableName}($keys) VALUES($token)";

        $stmt = $this->_db->prepare($sql);


        return $stmt->execute($values);
    }

    protected function delete()
    {

    }

    protected function update()
    {

    }

    public function fill($data)
    {
        foreach ($data as $k => $v) {
            if (!in_array($k, $this->fillable)) {
                unset($data[$k]);
            }
        }

        return $this->data = $data;
    }

}
