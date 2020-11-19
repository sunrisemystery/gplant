<?php

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function index(){
        // TODO display main.html
        $this->render('main');
    }

    public function login(){
        //TODO display login.html
        $this->render('login');
    }

    
    public function register(){
        //TODO display login.html
        $this->render('register');
    }
    public function myPlants(){
        //TODO display login.html
        $this->render('my-plants');
    }
}