<?php
namespace App\Controllers;

class ExtendController extends BaseController
{
    public function test()
    {
        if ($this->isPage('ExtendController', 'test')) {
            // Code specific to test page
        }
        
        $this->render('test', $data ?? []);
    }

    public function intro()
    {
        if ($this->isPage('ExtendController', 'intro')) {
            // Code specific to intro page
        }
        
        $this->render('intro', $data ?? []);
    }

    public function login()
    {
        if ($this->isPage('ExtendController', 'login')) {
            // Code specific to login page
        }
        
        $this->render('login', $data ?? []);
    }

    public function home()
    {
        if ($this->isPage('ExtendController', 'home')) {
            // Code specific to home page
        }
        
        $this->render('home', $data ?? []);
    }
}