<?php
namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function error404()
    {
        http_response_code(404);
        $this->view('component.error.404.index');
    }
}