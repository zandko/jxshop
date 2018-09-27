<?php

namespace controllers;

use libs\DB;
use PDO;

class CodeController
{
    public function make()
    {
        /**
         * 接收参数(生成代码的表名)
         */
        $tableName = $_GET['name'];

        /**
         * 搜集所有字段的白名单
         */
        $db = DB::getInstance();
        $stmt = $db->prepare("SHOW FULL FIELDS FROM $tableName");
        $stmt->execute();
        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $fillable = [];
        foreach ($fields as $v) {
            if ($v['Field'] == 'id' || $v['Field'] == 'created_at') {
                continue;
            }

            $fillable[] = $v['Field'];
        }
        $fillable = implode("','", $fillable);

        /**
         * 生成的文件名
         */
        $cname = ucfirst($tableName) . 'Controller';
        $mname = ucfirst($tableName);

        /**
         * 生成控制器
         */
        ob_start();
        include ROOT . 'templates/controller.php';
        $str = ob_get_clean();
        file_put_contents(ROOT . 'controllers/' . $cname . '.php', "<?php \r\n" . $str);

        /**
         * 生成模型
         */
        ob_start();
        include ROOT . 'templates/model.php';
        $str = ob_get_clean();
        file_put_contents(ROOT . 'models/' . $mname . '.php', "<?php \r\n" . $str);

        /**
         * 创建文件夹
         */
        @mkdir(ROOT . 'views/' . $tableName);
        chmod(ROOT . 'views/' . $tableName, 0777);

        /**
         * 生成视图文件
         */
        ob_start();
        include ROOT . "templates/create.html";
        $str = ob_get_clean();
        file_put_contents(ROOT . 'views/' . $tableName . '/create.html', $str);

        ob_start();
        include ROOT . "templates/create.html";
        $str = ob_get_clean();
        file_put_contents(ROOT . 'views/' . $tableName . '/edit.html', $str);

        ob_start();
        include ROOT . "templates/create.html";
        $str = ob_get_clean();
        file_put_contents(ROOT . 'views/' . $tableName . '/index.html', $str);

    }
}
