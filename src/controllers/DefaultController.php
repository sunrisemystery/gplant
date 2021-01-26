<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('main', ['isSession' => Utility::checkSession(), 'isAdmin' => Utility::isAdmin()]);
    }

    public function login()
    {
        $this->render('login');
    }
}