<?php

/**
 * 加载视图文件
 */
function view($file, $data = [])
{
    extract($data);
    $fileName = str_replace('.', '/', $file);
    require ROOT . 'views/' . $fileName . '.html';
}
