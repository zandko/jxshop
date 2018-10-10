<?php

namespace models;

class Admin extends Model
{
    /**
     * tableName 对应的表
     * fillable  设置允许接收的字段
     */
    protected $tableName = 'admin';
    protected $fillable = ['username', 'password'];

    public function _before_write()
    {
        $this->data['password'] = md5($this->data['password']);
    }

    protected function _after_write()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $this->data['id'];

        $stmt = $this->_db->prepare("DELETE FROM admin_role WHERE admin_id=?");
        $stmt->execute([
            $id,
        ]);

        $stmt = $this->_db->prepare("INSERT INTO admin_role(admin_id,role_id) VALUES(?,?)");
        // 循环所有勾选的权限ID插入到中间表
        foreach ($_POST['role_id'] as $v) {
            $stmt->execute([
                $v,
                $id,
            ]);
        }
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE username=? AND password=?";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([
            $username,
            $password,
        ]);

        $info = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($info) {
            $_SESSION['id'] = $info['id'];
            $_SESSION['username'] = $info['username'];

            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM admin_role WHERE role_id=1 AND admin_id=?');
            $stmt->execute([$_SESSION['id']]);
            $c = $stmt->fetch(\PDO::FETCH_COLUMN);
            if ($c > 0) {
                $_SESSION['root'] = true;
            } else {
                $_SESSION['url_path'] = $this->geturlPath($_SESSION['id']);
            }
        } else {
            throw new \Exception('用户名或者密码错误！');
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function geturlPath($adminId)
    {
        $sql = "SELECT  c.url_path
                    FROM admin_role a
                    LEFT JOIN role_privilege b ON a.role_id = b.role_id
                    LEFT JOIN privilege c ON b.pri_id = c.id
                    WHERE a.admin_id = ? AND c.url_path!''";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([$adminId]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $_ret = [];

        foreach ($data as $v) {
            if (false === strpos($v['url_path'], ',')) {
                $_ret[] = $v['url_path'];
            } else {
                $_tt = explode(',', $v['url_path']);

                $_ret = array_merge($_ret, $_tt);
            }
        }

        return $_ret;
    }
}
