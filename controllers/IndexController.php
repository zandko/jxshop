<?php

namespace controllers;

use models\Category;

class IndexController
{
    public function index()
    {
        view('index.index');
    }

    public function main()
    {
        view('index.main');
    }

    public function menu()
    {
        view('index.menu');
    }

    public function top()
    {
        view('index.top');
    }
}
