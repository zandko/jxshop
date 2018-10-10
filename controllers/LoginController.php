<?php

namespace controllers;

use models\Admin;

class LoginController
{
    public function login()
    {
        view('login.login');
    }

    public function dologin()
    {

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $model = new Admin;

        try
        {
            $model->login($username, $password);
            // 如果登录成功进入后台
            redirect('/');
        } catch (\Exception $e) {
            // 如果这个方法中抛出了异常就执行到这里

            redirect('/login/login');
        }
    }

    public function logout()
    {
        $model = new Admin;
        $model->logout();
        redirect('/login/login');
    }
}
