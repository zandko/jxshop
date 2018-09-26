<?php

namespace controllers;

use libs\DB;
use PDO;

class CodeController
{
    /**
     * 参数1：引入的文件
     * 参数2：生成的文件名
     */
    public function currency($path, $tableName)
    {
        $code = DB::getInstance();
        $stmt = $code->prepare("SHOW FULL FIELDS FROM $tableName");
        $stmt->execute();
        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ob_start();
        include ROOT . "templates/{$path}.html";
        $str = ob_get_clean();
        file_put_contents(ROOT . 'views/' . $tableName . '/' . $path . '.html', $str);
    }

    public function make()
    {
        $tableName = $_GET['name'];

        /**
         * 生成控制器
         */
        $cname = ucfirst($tableName) . 'Controller';
        ob_start();
        include ROOT . 'templates/controller.php';
        $str = ob_get_clean();
        file_put_contents(ROOT . 'controllers/' . $cname . '.php', "<?php \r\n" . $str);

        /**
         * 生成模型
         */
        $mname = ucfirst($tableName);
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
        $this->currency('create', $tableName);
        $this->currency('edit', $tableName);
        $this->currency('index', $tableName);

    }
}
