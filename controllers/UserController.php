<?php 

namespace controllers;

class UserController{   
    /**
     * 列表页
     */
    public function index()
    {
        view('user.index');
    }

    /** 
     * 显示添加的表单
     */
    public function create()
    {
        view('user.create');
    }

    /**
     * 处理添加的表单
     */
    public function insert()
    {

    }

    /**
     * 显示修改的表单
     */
    public function edit()
    {
        view('user.edit');
    }

    /**
     * 修改表单的方法
     */
    public function update()
    {
        
    }

    /**
     * 删除
     */
    public function delete()
    {

    }
}
