<?php

namespace models;

use libs\Uploader;

class Brand extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'brand';
    protected $fillable = ['brand_name', 'logo'];

    /**
     * 添加 修改前 自动调用
     */
    public function _before_write()
    {
        $this->_delete_logo();
        $Uploader = Uploader::make();
        $logo = '/uploads/' . $Uploader->upload('logo', 'brand');
        $this->data['logo'] = $logo;
    }

    /**
     * 删除之前被调用
     */
    public function _before_delete()
    {
        $this->_delete_logo();
    }

    /**
     * 删除图片
     */
    public function _delete_logo()
    {
        if (isset($_GET['id'])) {
            $ol = $this->findOne($_GET['id']);
            @unlink(ROOT . 'public/' . $ol['logo']);
        }
    }
}
