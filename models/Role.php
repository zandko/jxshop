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
        $id = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];

        $stmt = $this->_db->prepare("DELETE FROM role_privilege WHERE role_id=?");
        $stmt->execute([
            $id,
        ]);

        $stmt = $this->_db->prepare("INSERT INTO role_privilege(pri_id,role_id) VALUES(?,?)");
        // 循环所有勾选的权限ID插入到中间表
        foreach ($_POST['pri_id'] as $v) {
            $stmt->execute([
                $v,
                $id,
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

    public function getPriIds($roleId)
    {
        $stmt = $this->_db->prepare("SELECT pri_id FROM role_privilege WHERE role_id=?");
        $stmt->execute([
            $roleId,
        ]);

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $_ret = [];

        foreach ($data as $k => $v) {
            $_ret[] = $v['pri_id'];
        }

        return $_ret;
    }
}
