<?php

namespace models;

class Privilege extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'privilege';
    protected $fillable = ['pri_name', 'url_path', 'parent_id'];

    public function tree()
    {
        $data = $this->findAll();
        $ret = $this->_tree($data['data']);
        return $ret;
    }
}
