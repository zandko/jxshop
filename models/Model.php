<?php

namespace models;

use libs\DB;
use PDO;

class Model
{
    protected $_db;
    /**
     * tableName 操作的表名,值由子类设置
     * data      表单中的数据,值由控制器设置
     */
    protected $tableName;
    protected $data;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    /**
     * 钩子函数
     */
    protected function _before_write()
    {}
    protected function _after_write()
    {}
    protected function _before_delete()
    {}
    protected function _after_delete()
    {}

    /**
     * 对表的添加功能
     */
    public function insert()
    {
        $this->_before_write();

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

        $stmt = $this->_db->prepare("INSERT INTO {$this->tableName}($keys) VALUES($token)");
        $stmt->execute($values);

        $this->data['id'] = $this->_db->lastInsertId();

        $this->_after_write();
    }

    /**
     * 对表的删除功能
     */
    public function delete($id)
    {
        $this->_before_delete();

        $stmt = $this->_db->prepare("DELETE FROM {$this->tableName} WHERE id=?");
        $stmt->execute([$id]);

        $this->_after_delete();
    }

    /**
     * 对表的修改功能
     */
    public function update($id)
    {
        $this->_before_write();

        $set = [];
        $values = [];

        foreach ($this->data as $k => $v) {
            $set[] = "$k=?";
            $values[] = $v;
        }

        $set = implode(',', $set);
        $values[] = $id;

        $stmt = $this->_db->prepare("UPDATE {$this->tableName} SET $set WHERE id=?");

        $stmt->execute($values);

        $this->_after_write();
    }

    /**
     * 查询所有记录 并带有翻页
     */
    public function findAll($options = [])
    {
        $_option = [
            'fields' => '*',
            'where' => 1,
            'order_by' => 'id',
            'order_way' => 'desc',
            'per_page' => 20,
            'join' => '',
            'groupby' => '',
        ];

        if ($options) {
            $_option = array_merge($_option, $options);
        }

        /**
         * 翻页
         */
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($page - 1) * $_option['per_page'];

        $stmt = $this->_db->prepare("SELECT {$_option['fields']}
                                        FROM {$this->tableName} {$_option['join']}
                                        WHERE {$_option['where']} {$_option['groupby']}
                                        ORDER BY {$_option['order_by']} {$_option['order_way']}
                                        LIMIT $offset,{$_option['per_page']}");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->_db->prepare("SELECT COUNT(*) FROM {$this->tableName} WHERE {$_option['where']}");
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_COLUMN);

        $pageCount = ceil($count / $_option['per_page']);

        $page_str = "";
        if ($pageCount > 1) {
            for ($i = 1; $i <= $pageCount; $i++) {
                $page_str .= "<a href='?page=$i'>$i</a>";
            }
        }

        return [
            'data' => $data,
            'page' => $page_str,
        ];
    }

    /**
     * 查询单条记录
     */
    public function findOne($id)
    {
        $stmt = $this->_db->prepare("SELECT * FROM {$this->tableName} WHERE id=?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 接收表单中的数据
     */
    public function fill($data)
    {
        foreach ($data as $k => $v) {
            if (!in_array($k, $this->fillable)) {
                unset($data[$k]);
            }
        }
        return $this->data = $data;
    }

    /**
     * 递归排序
     * 参数一、排序的数据
     * 参数二、上级ID
     * 参数三、第几级
     */
    protected function _tree($data, $parent_id = 0, $level = 0)
    {
        static $_ret = [];

        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level;
                $_ret[] = $v;
                $this->_tree($data, $v['id'], $level + 1);
            }
        }

        return $_ret;
    }

}
