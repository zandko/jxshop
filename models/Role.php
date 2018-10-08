<?php 

namespace models;

class Role extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'role';
    protected $fillable = ['role_name'];
}
