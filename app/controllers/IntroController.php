<?php
namespace App\Controllers;

use App\Core\Controller;

class IntroController extends Controller
{
    public function index()
    {
        $this->view('intro.index');
    }
}