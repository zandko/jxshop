<?php

namespace models;

use libs\Uploader;

class Goods extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'goods';
    protected $fillable = ['goods_name', 'logo', 'is_on_sale', 'description', 'cat1_id', 'cat2_id', 'cat3_id', 'brand_id'];

    /**
     * 添加 修改 之前 自动执行
     */
    public function _before_write()
    {
        $this->_delete_logo();
        $uploader = Uploader::make();
        $logo = '/uploads/' . $uploader->upload('logo', 'goods');
        $this->data['logo'] = $logo;
    }

    /**
     * 删除前自动执行
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
            $data = $this->findOne($_GET['id']);
            @unlink(ROOT . 'public/' . $data['logo']);
        }
    }

    /**
     * 添加 修改 后自动执行
     */
    public function _after_write()
    {
        /**
         * 商品属性
         */
        $stmt = $this->_db->prepare("INSERT INTO goods_attribute(attr_name,attr_value,goods_id) VALUES(?,?,?)");

        foreach ($_POST['attr_name'] as $k => $v) {
            $stmt->execute([
                $v,
                $_POST['attr_value'][$k],
                $this->data['id'],
            ]);
        }

        /**
         * 商品图片
         */
        $stmt = $this->_db->prepare("INSERT INTO goods_image(goods_id,path) VALUES(?,?)");
        $tmp_name = [];

        $uploader = Uploader::make();

        foreach ($_FILES['image']['name'] as $k => $v) {

            $tmp_name['name'] = $v;
            $tmp_name['type'] = $_FILES['image']['type'][$k];
            $tmp_name['tmp_name'] = $_FILES['image']['tmp_name'][$k];
            $tmp_name['error'] = $_FILES['image']['error'][$k];
            $tmp_name['size'] = $_FILES['image']['size'][$k];

            $_FILES['tmp'] = $tmp_name;

            $path = '/uploads/' . $uploader->upload('tmp', 'goods');

            $stmt->execute([
                $this->data['id'],
                $path,
            ]);
        }

        /**
         * 商品 sku
         */
        $stmt = $this->_db->prepare("INSERT INTO goods_sku(goods_id,sku_name,stock,price) VALUES(?,?,?,?)");
        foreach ($POST['sku_name'] as $k => $v) {
            $stmt->execute([
                $this->data['id'],
                $v,
                $_POST['stock'][$k],
                $_POST['price'][$k],
            ]);
        }

    }

}
