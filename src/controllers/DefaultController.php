<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {

        $this->render('main');
    }

    public function login()
    {

        $this->render('login');
    }


    public function discover()
    {

        $this->render('discover');
    }

}