<?php
namespace App\Controllers;
class ExtendController extends BaseController
{
    public function test()
    {
        $this->render('test');
    }

    public function intro()
    {
        $this->render('intro');
    }
}