<?php
namespace app\controllers;

use app\core\controller;

class introcontroller extends controller
{
    public function index()
    {
        $this->view('intro.index');
    }
}