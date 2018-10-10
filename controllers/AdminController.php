<?php

namespace controllers;

use models\Admin;

class AdminController extends BaseController
{
    /**
     * 列表页
     */
    public function index()
    {
        $model = new Admin;
        $data = $model->findAll();
        view('admin.index', $data);
    }

    /**
     * 显示添加的表单
     */
    public function create()
    {
        $model = new \models\Role;
        $data = $model->findAll();
        view('admin.create', $data);
    }

    /**
     * 处理添加的表单
     */
    public function insert()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->insert();
        redirect('/admin/index');
    }

    /**
     * 显示修改的表单
     */
    public function edit()
    {
        $model = new Admin;
        $data = $model->findOne($_GET['id']);
        view("/admin/edit", [
            'data' => $data,
        ]);
    }

    /**
     * 修改表单的方法
     */
    public function update()
    {
        $model = new Admin;
        $model->fill($_POST);
        $model->update($_GET['id']);
        redirect('/admin/index');
    }

    /**
     * 删除
     */
    public function delete()
    {
        $model = new Admin;
        $model->delete($_GET['id']);
        redirect("/admin/index");
    }

    
}
