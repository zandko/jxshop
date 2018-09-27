<?php 

namespace models;

class Brand extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'brand';
    protected $fillable = ['brand_name','logo'];
}
