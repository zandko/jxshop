<?php

define('ROOT', __DIR__ . '/../');

require ROOT.'libs/function.php';
/**
 * 自动加载类
 */
function autoload($class)
{
    $path = str_replace('\\', '/', $class);
    require ROOT . $path . '.php';
}

spl_autoload_register('autoload');

/**
 * 解析路由
 */
if (php_sapi_name() == 'cli') {
    $controller = ucfirst($argv[1]) . 'Controller';
    $action = $argv[2];
} else {
    if (isset($_SERVER['PATH_INFO'])) {
        $path = explode('/', $_SERVER['PATH_INFO']);
        $controller = ucfirst($path[1]) . 'Controller';
        $action = $path[2];
    } else {
        $controller = "IndexController";
        $action = "index";
    }
}

$fillController = "controllers\\" . $controller;

$_C = new $fillController;
$_C->$action();
