<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    public function login(){
        $user = new User('jsnow@mail.com','admin','John','Snow');

        if(!$this->isPost()){
            return $this->render('login');
        }

        $email = $_POST["login"];
        $password = $_POST["password"];

        if($user->getEmail()!==$email){
            return $this->render('login',['messages' => ['User with this login doesnt exist!']]);
        }
        if($user->getPassword()!==$password){
            return $this->render('login',['messages' => ['Incorrect password']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/myPlants");
//        return $this->render('my-plants');


    }
}