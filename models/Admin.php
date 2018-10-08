<?php 

namespace models;

class Admin extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'admin';
    protected $fillable = ['username','password'];
}
