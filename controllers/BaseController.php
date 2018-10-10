<?php

namespace controllers;

class BaseController
{
    public function _construct()
    {
        if (!isset($_SESSION['id'])) {
            redirect('/login/login');
        }

        if(isset($_SESSION['root']))
        {
            return ;
        }
        $path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : 'index/index';
        $whiteList = ['index/index', 'index/menu', 'index/top', 'index/main'];
        if (!in_array($path, array_merge($whiteList, $_SESSION['url_path']))) {
            die('无权访问!');
        }
    }
}
