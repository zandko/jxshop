<?php 

namespace controllers;

class AaaController{   
    /**
     * 列表页
     */
    public function index()
    {
        view('aaa.index');
    }

    /** 
     * 显示添加的表单
     */
    public function create()
    {
        view('aaa.create');
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
        view('aaa.edit');
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
