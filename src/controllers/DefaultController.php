<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index(){

        $this->render('main');
    }

    public function login(){

        $this->render('login');
    }

    
    public function register(){

        $this->render('register');
    }
    public function myPlants(){

        $this->render('my-plants');
    }
    public function plant(){

        $this->render('plant');
    }
    public function discover(){

        $this->render('discover');
    }

}