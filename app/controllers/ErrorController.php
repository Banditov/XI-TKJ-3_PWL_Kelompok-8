<?php
namespace app\controllers;

use app\core\controller;

class errorcontroller extends controller
{
    public function error404()
    {
        http_response_code(404);
        $this->view('error.404.index');
    }
}