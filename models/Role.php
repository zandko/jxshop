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

    protected function _after_write()
    {
        $stmt = $this->_db->prepare("INSERT INTO role_privilege(pri_id,role_id) VALUES(?,?)");
        // 循环所有勾选的权限ID插入到中间表
        foreach ($_POST['pri_id'] as $v) {
            $stmt->execute([
                $v,
                $this->data['id'],
            ]);
        }
    }

    protected function _before_delete()
    {
        $stmt = $this->_db->prepare("DELETE FROM role_privilege WHERE role_id=?");
        $stmt->execute(
            [$_GET['id']]
        );
    }
}
